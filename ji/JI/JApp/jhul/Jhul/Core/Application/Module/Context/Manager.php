<?php namespace Jhul\Core\Application\Module\Context;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017OCT14
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{

	private $_map = [];

	private $_moduleKey;

	public function __construct( $contextMap = [], $moduleKey )
	{
		$this->_map = $contextMap;

		$this->_moduleKey=  $moduleKey;
	}

	public function register( $map, $addonKey = NULL )
	{
		foreach ($map as $key => $class)
		{
			if( NULL != $addonKey )
			{
				$key = $addonKey.'@'.$key;
			}

			$this->_map[$key] = $class;
		}
	}

	public function get( $contextKey )
	{
		if( isset( $this->_loadedContexts[$contextKey] ) )
		{
			return $this->_loadedContexts[$contextKey] ;
		}

		foreach ( $this->map()  as $key => $class )
		{
			if( $key == $contextKey )
			{
				return  $this->_loadedContexts[$contextKey] = new $class( $key ) ;
			}
		}

		throw new \Exception( 'Context "'.$contextKey.'" Not Found In Module "'.$this->_moduleKey.'" ' , 1);
	}

	public function getByNamespace( $namespace )
	{

		$pos = strrpos( $namespace, '_\\' );

		$rContext = substr( $namespace, 0, $pos+1 ).'\\Context';


		$key = array_search( $rContext, $this->map() );

		if( $key )
		{
			return $this->get($key) ;
		}

		throw new \Exception( 'Context Not Defined For Class "'.$namespace.'"' , 1);
	}

	public function map()
	{
		return $this->_map;
	}

}
