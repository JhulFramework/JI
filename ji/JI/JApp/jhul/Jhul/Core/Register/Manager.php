<?php namespace Jhul\Core\Register;

/* @Author: Manish Dhruw
+=======================================================================================================================
| @Created : 2017NOV19
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	// array of register objects
	private $_registers = [];

	private $_registerDirectory = 'register';

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

	public function loadData($registerKey)
	{
		return $this->j()->mSysFileStore()->readConfig( $this->getDirNamespace($registerKey) ) ;
	}

	public function getDirNamespace( $registerKey )
	{
		return $this->_registerDirectory.'/'.$registerKey;
	}

	public function save( $registerKey )
	{
		if( $this->isLoaded( $registerKey ) )
		{
			$this->j()->mSysFileStore()->saveConfig( $this->get($registerKey)->data(), $this->getDirNamespace($registerKey) );
			// $file = $this->storeDirectoryPath().'/_'.$register_key.'.json';
			// $this->j()->fx()->saveToFile( json_encode( $this->get($register_key)->data(), JSON_PRETTY_PRINT ), $file );
		}
	}

}
