<?php namespace Jhul\Core\Application;

class ClientRequest
{
	protected $_params = [];

	public function __construct( $params = [] )
	{
		$this->_params =  $params;
	}

}
