<?php namespace Jhul\Components\ResourceManager;

class Component
{
	use \Jhul\Core\Design\Component\_Trait;

	protected $_system_manager;
	protected $_ui;


	public function __construct( $params )
	{
		$this->config()->add( $params );
	}

	// //system resouce manage
	// public function mPublic()
	// {
	// 	if( empty($this->_public_manager) )
	// 	{
	// 		$this->_public_manager = new PublicManager( $this );
	// 	}
	//
	// 	return $this->_public_manager;
	// }

	//system resouce manage
	public function mSystem()
	{
		if( empty($this->_system_manager) )
		{
			$this->_system_manager = new SystemManager( $this );
		}

		return $this->_system_manager;
	}


	public function ui()
	{
		if( empty($this->_ui) )
		{
			$this->_ui = new UI( $this->getApp()->url().'/'.$this->config( 'public_resource_directory') );
		}

		return $this->_ui;
	}
}
