<?php namespace JI\Register;

/* @Author: Manish Dhruw
+=======================================================================================================================
| @Created : 2017NOV19
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \JI\_AccessKey;

	// array of register objects
	private $_registers = [];

	//operation directory relative to JI Root
	private $_storeDirectoryPath;

	public function __construct( $path )
	{
		$this->_storeDirectoryPath = $path;
	}

	public function get( $key )
	{
		if( !isset($this->_registers[$key]) )
		{
			$this->_registers[$key] = new Register($key, $this->loadData($key));
		}

		return $this->_registers[$key] ;
	}

	public function isLoaded( $register_key )
	{
		return isset($this->_registers[$register_key]) ;
	}

	public function loadData($register_key)
	{
		$file = $this->storeDirectoryPath().'/_'.$register_key.'.json';

		if( file_exists($file) )
		{
			return json_decode( file_get_contents($file), TRUE) ;
		}

		return [] ;
	}

	public function save( $register_key )
	{
		if( $this->isLoaded( $register_key ) )
		{
			$this->_initDIR( $this->storeDirectoryPath() );
			$file = $this->storeDirectoryPath().'/_'.$register_key.'.json';
			file_put_contents( $file, json_encode( $this->get($register_key)->data(), JSON_PRETTY_PRINT ) );
		}
	}

	private function _initDir( $directory  )
	{
		if ( !file_exists( $directory ) )
		{
			mkdir( $directory , 0755, true);
		}
	}

	public function storeDirectoryPath()
	{
		return $this->_storeDirectoryPath ;
	}
}
