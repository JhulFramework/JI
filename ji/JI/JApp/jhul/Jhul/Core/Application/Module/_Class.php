<?php namespace Jhul\Core\Application\Module ;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Responsibilities
| -loads configuration from module
|
| @Created
| -Friday 19 December 2014 08:23:15 PM IST
|
| @Updated
| -Saturday 23 May 2015 06:21:56 PM IST
| -Sun 15 Nov 2015 07:25:41 PM IST
| -[2016-Oct-01, 2017-Aug-30, 2017-DEC-01]
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	protected $_path;

	protected $_dirNamespace ;
	protected $_addOnMap ;

	protected $_contextMap = [];
	protected $_namespaceToContextKeyMap = [] ;

	protected $_mContext ;

	public $elementMap = [];

	//Name of the module
//	protected $_name ;

	protected $_key ;

	protected $_config;

	public function config( $key = NULL, $required = TRUE )
	{
		if( empty($this->_config) ) { $this->_config = new \Jhul\Core\Containers\Config; }

		if( !empty( $key ) ) return $this->_config->get($key, $required);

		return $this->_config;
	}

	public function addOnMap()
	{
		return [] ;
	}

	// public function registerAddonContext( $addonKey, $contextMap )
	// {
	//
	// }

	public function mContext(){ return  $this->_mContext; }

	public function addOn( $key )
	{
		if( isset($this->_loadedAddOn[$key]) )
		{
			return $this->_loadedAddOn[$key] ;
		}

		$this->loadAddon( $key );

		return $this->_loadedAddOn[$key] ;
	}

	private function loadAddon( $key )
	{
		if( !isset($this->_addOnMap[$key]) )
		{
			throw new \Exception( 'Addon "'.$key.'" Not Found ' , 1);
		}

		$addOnClass = $this->_addOnMap[$key];

		$addOn = new $addOnClass( $key, $this->path().'/addon/'.$key );

		$this->mContext()->register( $this->app()->configLoader()->loadContextMap($addOn->path()), $addOn->key() );

		$this->_loadedAddOn[$key] = $addOn;
	}

	public function __construct( $key, $path )
	{
		$this->_key = $key;
		$this->_path = $path;
	}

	public function contextMap()
	{
		return $this->_contextMap ;
	}

	public function getContext( $contextKey )
	{
		return  $this->mContext()->get($contextKey);
	}

	public function getContextByNamespace( $forClass )
	{
		return $this->mContext()->getByNamespace( $forClass ) ;
	}

	public function key()
	{
		return $this->_key;
	}

	public function dirNamespace()
	{
		return $this->_dirNamespace;
	}

	public function dataStoreDirectoryPath()
	{
		return $this->app()->dataStoreDirectoryPath().'/'.$this->dirNamespace();
	}

	public function pubCachePath()
	{
		return $this->app()->mPubCache()->path().'/'.$this->dirNamespace();
	}

	//e.g (webitse.com/) resource/_m/module_key
	public function pubResUrl()
	{
		return $this->app()->pubResUrl().'/'.$this->dirNamespace();
	}

	public function pubCacheUrl()
	{
		return $this->app()->pubCacheUrl().'/'.$this->dirNamespace();
	}

	public static function getClass() { return static::class; }

	public function path()
	{
		return $this->_path;
	}

	public function makePage( $name )
	{
		if( !strrpos($name, '\\' ) && !strpos($name, $this->getApp()->mapper()->pageIdentifier() ) )
		{
			$name = $this->key().$this->getApp()->mapper()->pageIdentifier().$name;
		}

		$this->getApp()->makePage($name) ;
	}

	public function cook( $name, $params = [] )
	{
		if( 'webpage' == $this->getApp()->outputMode() && !strpos($name, $this->getApp()->mapper()->viewIdentifier() )  )
		{
			$name = $this->key().$this->getApp()->mapper()->viewIdentifier().$name;
		}

		$this->getApp()->response()->page()->cook( $name, $params );
	}

	public function loadResource( $fileName )
	{
		$data = require( $this->path().'/res/'.$fileName.'.php' );

		return is_array( $data ) ? $data : [] ;
	}

	public function registerView( $view_name, $view_file )
	{
		$this->getApp()->mapper()->registerView( $this->key(), $view_name, $view_file );
	}

	public function _s( $prop, $value )
	{
		$prop = '_'.$prop;

		$this->$prop = $value;

		return $this;
	}
}
