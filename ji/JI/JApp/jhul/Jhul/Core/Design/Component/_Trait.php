<?php namespace Jhul\Core\Design\Component;


trait _Trait
{

	//component key
	private $_key;

	protected $_config;

	public function J()
	{
		return \Jhul::I();
	}

	public function app()
	{
		return $this->J()->app() ;
	}

	public function config( $key = NULL, $required = TRUE )
	{
		if( empty($this->_config) ) { $this->_config = new \Jhul\Core\Containers\Config; }

		if( !empty( $key ) ) return $this->_config->get($key, $required);

		return $this->_config;
	}

	final public function _s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
	}

	public final function _key()
	{
		return $this->_key ;
	}

	public function dataStoreDirectoryPath()
	{
		return $this->j()->dataStoreDirectoryPath().'/'.$this->_key() ;
	}
}
