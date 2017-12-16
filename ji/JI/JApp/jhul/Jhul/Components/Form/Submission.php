<?php namespace Jhul\Components\Form;

/*/ @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017DEC05
+--------------------------------------------------------------------------------------------------------------------/*/

class Submission
{

	/*
	| @Structiure = [ 'field' => $valueObject ]
	*/
	private $_map = [];

	/*
	| @Structiure = [ 'field' => 'value' ]
	*/
	private $_data = [];


	public function set( $key, $value )
	{
		$this->_map[$key] = $value;
		$this->_data[$key] = $value->value();
	}

	public function get( $key )
	{
		return $this->_map[$key] ;
	}

	public function has( $key )
	{
		return isset($this->_map[$key]) ;
	}

	public function map()
	{
		return $this->_map;
	}

	public function data()
	{
		return $this->_data;
	}
}
