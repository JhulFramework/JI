<?php namespace Jhul\Core\Application\User;


/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Sun 07 Feb 2016 06:45:57 PM IST
|
| Requested URI Node
+---------------------------------------------------------------------------------------------------------------------*/

class Navigator
{

	private $_segments = [];

	private $_value = '' ;

	protected $_pointer = 1;

	public function __construct( $value, $segments )
	{
		$this->_value = $value;

		foreach ( $segments as $key => $s)
		{
			$this->_segments[$key] = urlDecode($s);
		}

	}

	public function current()
	{
		return $this->_segments[ $this->_pointer ] ;
	}

	public function next( $data_type_filter = NULL )
	{
		if( isset( $this->_segments[ $this->_pointer + 1 ] ) )
		{
			return $this->_segments[ $this->_pointer + 1 ] ;
		}
	}

	public function hasNext()
	{
		 return isset( $this->_segments[ $this->_pointer + 1 ] );
	}

	public function moveToNext() { ++$this->_pointer; }

	public function value() { return $this->_value; }

	public function last(){ return end($this->_segments); }

	public function get( $pointer )
	{
		if( isset( $this->_segments[$pointer] ) )
		{
			return $this->_segments[$pointer] ;
		}
	}

	public function __toString()
	{
		return $this->value();
	}

	public function map()
	{
		return $this->_segments;
	}

	function getFrom( $fromIndex, $preserveKeys = TRUE )
	{
		return array_slice( $this->map(), $fromIndex, NULL, $preserveKeys );
	}
}
