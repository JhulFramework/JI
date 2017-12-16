<?php namespace Jhul\Core\Application\Response\JSON;

class JSON
{
	use \Jhul\Core\_AccessKey;

	private static $_data;

	public function __construct()
	{
		static::$_data = new \stdClass();
		$this->cook("ifLoggedIn", !$this->app()->user()->isAnon() );
	}

	public function cook( $key, $value = "" )
	{

		if( is_array( $key ) )
		{
			foreach ($key as $k => $v)
			{
				$this->cook( $k, $v );
			}

			return ;
		}


		static::$_data->$key = $value;
	}

	public function type(){ return 'json'; }


	public function isEmpty()
	{
		return empty( static::$_data );
	}

	public function make()
	{
		return json_encode( static::$_data );
	}


	public function contentTypeHeader()
	{
		return 'application/json';
	}
}
