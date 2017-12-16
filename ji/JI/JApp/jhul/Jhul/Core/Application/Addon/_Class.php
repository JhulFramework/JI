<?php namespace Jhul\Core\Application\Addon;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017Oct14
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	private $_key;
	private $_path;

	public function __construct( $key, $path )
	{
		$this->_key  = $key;
		$this->_path = $path;
	}

	public function key()
	{
		return $this->_key;
	}

	public function path()
	{
		return $this->_path;
	}

	public function context( $key )
	{
		return $this->module()->getContext( $this->key().'@'.$key ) ;
	}

}
