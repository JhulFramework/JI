<?php namespace Jhul\Components\Form;

/*/ @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017-june-2
|
| @Updated : 2017DEC03
+--------------------------------------------------------------------------------------------------------------------/*/

class FieldManager
{

	private $_map = [] ;

	private $_keys = [] ;

	private $_dataTypeMap = [] ;

	public function __construct( $fields )
	{
		$this->setMap( $fields );
	}

	public function setMap( $map )
	{
		$this->_map = $map ;

		foreach ($map as $field => $params)
		{
			$this->_keys[] = $field;
			$this->_dataTypeMap[$field] = $params['data_type'];
		}

		return $this ;
	}

	public function map()
	{
		return $this->_map ;
	}

	public function dataTypeMap()
	{
		return $this->_dataTypeMap;
	}

	public function has( $field, $param )
	{
		if(isset( $this->_map[$field]  ) )
		{
			return isset($this->_map[$field][$param]) ;
		}

		return FALSE ;
	}

	public function id( $name )
	{
		return $this->get( $name, 'id' );
	}

	public function label( $name )
	{
		return $this->get( $name, 'label' );
	}

	public function dataType( $name )
	{
		return $this->get( $name, 'data_type' );
	}

	public function viewType( $field )
	{
		return $this->get( $field, 'view_type' );
	}

	public function keys() { return $this->_keys; }

	public function get( $name = NULL, $param = NULL, $required = FALSE )
	{
		if( NULL == $name ) return $this->_map;

		if( isset( $this->_map[$name] ) )
		{
			if( NULL == $param ) return $this->_map[$name];

			if( isset( $this->_map[$name][$param] ) ) return $this->_map[$name][$param];

			if( !$required ) return NULL;

			throw new \Exception( 'Parameter "'.$param.'" Not Set For Form Field "'.$name.'" ' , 1);
		}

		throw new \Exception( 'Form Field "'.$name.'" not defined !' , 1);

	}
}
