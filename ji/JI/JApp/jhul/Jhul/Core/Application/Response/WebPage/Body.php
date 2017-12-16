<?php namespace Jhul\Core\Application\Response\WebPage;

class Body
{
	protected $_script;

	private $_data =
	[
		'content' => '',
	];

	public function add( $content ) { $this->_data['content'] .= $content; }

	public function get( $key )
	{
		if( isset( $this->_data[$key] ) ) return $this->_data[$key];
	}

	public function set( $key, $value )
	{
		$this->_data[$key] = $value;
	}

	public function remove( $key )
	{
		if( isset( $this->_data[$key] ) )
		{
			unset( $this->_data[$key] );
		}
	}

	public function has( $e )
	{
		return !empty( $this->_data[$e] ) ;
	}

	public function script()
	{
		if( empty($this->_script) )
		{
			$this->_script = new Script;
		}

		return $this->_script;
	}

	public function isEmpty()
	{
		return !empty( $this->_data['content'] );
	}
}
