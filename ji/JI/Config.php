<?php namespace JI;

class Config
{
	use \JI\_AccessKey;

	const STORE_KEY = 'config';

	private $_config = [];

	public function __construct()
	{
		$this->_config = $this->JI()->store()->load( static::STORE_KEY );
	}

	public function get($key)
	{
		if( isset($this->_config[$key]) )
		{
			return $this->_config[$key];
		}

		throw new \Exception( 'Configuration "'.$key.'" Not Set!' , 1);
	}

	public function set( $key, $value)
	{
		$this->_config[$key] = $value;
		return $this ;
	}

	public function commit()
	{
		$this->JI()->saveData( static::STORE_KEY, $this->_config );
	}
}
