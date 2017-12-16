<?php namespace Jhul\Core\Application\Response\WebPage;

/* @Author : Manish Dhruw
+=======================================================================================================================
| Created : 20170ct16
+---------------------------------------------------------------------------------------------------------------------*/

class Layout
{
	protected $_script;

	private $_map =
	[
		'header' => 'main.header',

		'footer' => 'main.footer',
	];

	public function map()
	{
		return $this->_map ;
	}

	public function get( $key )
	{
		if( isset( $this->_map[$key] ) ) return $this->_map[$key];
	}

	public function add( $key, $value )
	{
		$this->_map[$key] = $value;
	}

	public function remove( $key )
	{
		if( isset( $this->_map[$key] ) )
		{
			unset( $this->_map[$key] );
		}
	}

	public function has( $e )
	{
		return !empty( $this->_map[$e] ) ;
	}
}
