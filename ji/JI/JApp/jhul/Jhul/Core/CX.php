<?php namespace Jhul\Core;

/* @Author : Manish Dhruw <1D3N717Y12@gmail.com>
+=======================================================================================================================
| @Created 2016:Oct-07
|
| Component Loader
|
| psuedo :
|	$_paths
|	$_config_files
|	$_config_override
|
|	setPath($path)
|	registerConfigFile( $dep_name, $file_path )
|	registerConfigFiles( $map )
|	_create() //creates the dependency object
|	_init() //initializes dependency object
|
| @Updated : 2017DEC02
+---------------------------------------------------------------------------------------------------------------------*/

class CX
{
	use _AccessKey;

	protected $_componentMap = [];

	/*
	| @Preference : Primary
	*/
	private $_serverConfigPath;

	/*
	| @Prefrence : Secondary
	*/
	private $_appConfigPath ;

	/*
	| @Prefrence : Fallback
	| Component Assembly Directory Path
	| Also Serves as fallback config path
	*/
	private $_assemblyPath;

	private $_loaded = [] ;

	public function get($key)
	{
		if( isset($this->_loaded[$key]) ) return $this->_loaded[$key];

		return $this->_get($key);
	}

	private function _get($key)
	{
		$this->_loaded[$key] = NULL;

		$this->inject( $this->_loaded[$key], $key );

		return $this->_loaded[$key];
	}

	public function readConfig( $componentKey )
	{
		$file = $this->_serverConfigPath.'/'.$componentKey.'/_config.php';

		if( !is_file($file) )
		{
			$file = $this->_appConfigPath.'/'.$componentKey.'/_config.php';
		}

		if( is_file($file) )
		{
			return $this->j()->fx()->readConfigFile( $file, FALSE ) ;
		}
	}

	public function inject( &$component, $componentKey )
	{
		$config = $this->readConfig( $componentKey );

		if( isset( $this->_componentMap[$componentKey] ) )
		{
			$class = $this->_componentMap[$componentKey];

			$component = new $class( $config ) ;

			$component->_s( 'key', $componentKey );

			$component->config()->add( $config );
		}
		else
		{
			throw new \Exception( 'Component "'.$componentKey.'" Not Mapped' , 1);
		}

		$assembly = $this->readAssembly( $componentKey );

		if( empty($assembly) ) return;

		/*
		| @Important : Component must be created and assigned before intializing
		| Assigning component to variable
		*/
		$component = $this->_create( $component, $assembly, $config );

		$component = $this->_init( $component, $assembly, $config );
	}

	private function _create( $component, $assembly, $config )
	{
		if( isset( $assembly['create'] ) )
		{
			$creator = $assembly['create'];

			$component = $creator( $component, $config );
		}

		return $component;
	}

	//@params (object) $com
	private function _init( $com, $assembly, $config )
	{
		if( isset( $assembly['init'] ) )
		{
			$initializer = $assembly['init'];

			$com = $initializer( $com, $config );
		}

		return $com;
	}

	public function readAssembly( $componentKey)
	{
		return $this->J()->fx()->loadConfigFile
		(
			$this->_assemblyPath.'/'.$componentKey.'/_assembly',
			FALSE
		);
	}

	public function setAppConfigPath( $path )
	{
		$this->_appConfigPath = $path ;
		return $this ;
	}

	public function setServerConfigPath( $path )
	{
		$this->_serverConfigPath = $path ;
		return $this ;
	}


	public function setAssemblyPath( $path )
	{
		$this->_assemblyPath = $path;
		$this->_componentMap = $this->J()->fx()->loadConfigFile( $path.'/_component_map', FALSE );
		return $this ;
	}
}
