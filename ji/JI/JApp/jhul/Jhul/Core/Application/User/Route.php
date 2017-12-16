<?php namespace Jhul\Core\Application\User;


/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 13-Jun-2016
|
|
| @Update : [2016-02-11, 2017-April-22]
+---------------------------------------------------------------------------------------------------------------------*/

class Route
{
	use \Jhul\Core\_AccessKey;

	//HANDLER NODE
	protected $_navigator;

	private $_params;

	public function __construct( $params )
	{
		$this->_params 	= array_merge( $params, $this->app()->m()->mapper()->resolve( $params['target'] ) );

		$this->_navigator	= new Navigator( $params['value'], $params['segments'] );
	}

	public function statusCode() { return $this->_params['status_code']; }

	public function key()
	{
		return $this->_params['key'];
	}

	public function moduleKey()
	{
		return $this->_params['module'];
	}

	public function resource()
	{
		return $this->_params['resource'];
	}

	public function target()
	{
		return $this->_params['target'];
	}

	public function params()
	{
		return $this->_params['params'];
	}

	public function getParam( $key, $type )
	{
		$value = null;

		if( isset( $this->_params['params'][ $key ] )  )
		{
			$value = $this->_params['params'][$key];
		}

		return $this->app()->mDataType( $type )->make( $value );
	}

	public function hasParam( $key )
	{
		return  isset($this->_params['params'][$key]) ;
	}


	public function navigator()
	{
		return $this->_navigator;
	}

	public function typeIdentifier()
	{
		return $this->_params['type_identifier'];
	}

	public function type()
	{
		return $this->_params['type'];
	}
}
