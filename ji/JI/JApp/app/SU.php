<?php namespace app;

class SU extends \Jhul\Core\Application\User\_Class
{
	public function __construct( $app_url )
	{
		parent::__construct( $app_url );

		$this->_modules = $this->app()->m('admin')->getSUData($this->iname())['modules'];
	}

	private $_modules = [] ;

	public function accessModules()
	{
		return $this->_modules;
	}

	public function canAdminModule( $moduleKey )
	{
		return isset( $this->_modules[$moduleKey] ) ;
	}

	public function sessionStoreKey()
	{
		return '__SU_';
	}

	public function keyName()
	{
		return 'su_key';
	}

	public function iname()
	{
		return $this->getState('iname');
	}

	public function name()
	{
		return $this->getState('name');
	}

	public function url()
	{
		return $this->app()->url().'/@'.$this->iname();
	}

	public function tagline()
	{
		return $this->getState('tagline');
	}

	public function avatar()
	{
		return $this->getState('avatar');
	}

	public function DAOClass()
	{
		return '\\_modules\\user\\context\\siu\\dao\\User';
	}

	public function canAccessContext( $moduleKey, $context )
	{
		return isset( $this->_modules[$moduleKey][$context] ) ;
	}

}
