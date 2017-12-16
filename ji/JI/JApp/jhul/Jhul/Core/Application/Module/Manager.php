<?php namespace Jhul\Core\Application\Module;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Updated : [ 2016-august-01, 2016-Oct-01, 2016-Oct-16, 2017-02-12,2017nov21 ]
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{

	use \Jhul\Core\_AccessKey;

	const REGISTER_DATA_KEY = 'installed_modules';

	private $_installed_modules = [];

	//TODO Cache it, and check performance
	protected $_loaded_module = [];

	public function __construct()
	{
		$this->_installed_modules = $this->j()->register()->get( static::REGISTER_DATA_KEY, FALSE );
	}

	public function fx()
	{
		return $this->j()->fx() ;
	}

	public function mapper()
	{
		return $this->app()->mapper();
	}

	//@Params : $name = name of module
	public function g( $name )
	{
		if( !isset( $this->_loaded_module[$name] ) )
		{

			$this->load( $name );
		}

		return $this->_loaded_module[ $name ];
	}

	protected function load( $name )
	{
		$modulePath = $this->app()->path().'/module/'.$name;

		$module_class = '_m\\'.$name.'\\Module';

		if( !class_exists($module_class) )
		{
			throw new \Exception( 'Module class "'.$module_class.'" Not Found' , 1);
		}

		$module = new $module_class( $name, $modulePath );

		$module->_s( 'dirNamespace',	'app/_m/'.$module->key() );

		$module->_s( 'mContext', new Context\Manager( $this->loadContexts( $modulePath ), $module->key() ) );

		$module->_s
		(
			'addOnMap',
			 $this->fx()->loadConfigFile(  $modulePath.'/_config/_addons', FALSE )
		);

		$this->_loaded_module[ $name ] = $module;

		$this->app()->configLoader()->load( $this->_loaded_module[ $name ] ) ;

		if(  !isset( $this->_installed_modules[$module->key()]) )
		{
			$this->install( $module );
		}
	}

	public function loadContexts( $path )
	{
		$contexts = $this->fx()->loadConfigFile(  $path.'/_config/_contexts', FALSE );

		array_multisort(array_map('strlen', $contexts), $contexts);

		return array_reverse($contexts);
	}

	public function install( $module )
	{
		$installer_file = $module->path().'/install/Installer.php';

		if( file_exists($installer_file  ) )
		{
			$class = $this->fx()->rChop( get_class($module) ).'\\install\\Installer';

			$class::I( $module )->_install();
		}

		$this->installAddons($module);

		$this->_installed_modules[$module->key()] = $module->key();

		$this->j()->register()->set( static::REGISTER_DATA_KEY, $this->_installed_modules );
		$this->j()->register()->commit();

		//$this->app()->mSysCache()->writeConfig( static::MODULE_REGISTER_NAME, $this->_installed_modules );
	}

	public function installAddons( $module )
	{
		foreach ($module->addOnMap() as $key => $class)
		{
			$setupFile = $module->path().'/addon/'.$key.'/_install/Installer.php';

			if( file_exists($setupFile) )
			{
				$class = $this->fx()->rChop( $class ).'\\_install\\Installer';

				$class::I( $module )->_install();
			}
		}
	}

	public function __toString()
	{
		return json_encode( $this->_module_map );
	}
}
