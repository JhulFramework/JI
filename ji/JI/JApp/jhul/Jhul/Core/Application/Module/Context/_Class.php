<?php namespace Jhul\Core\Application\Module\Context;

/*
| @Author : Manish Dhruw
+=======================================================================================================================
| @Created : 2017-Jul-18
| @Updated : [2017-Aug-30]
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{
	use \Jhul\Core\_AccessKey;

	private $_name;

	private $_key;

	private $_classNamespace;

	private $_form;

	private $_page;

	public function __construct( $name )
	{
		$this->_name = $name;

		$this->_key =  $this->module()->key().'@'.$name;

		$this->_classNamespace = $this->j()->fx()->rchop(get_called_class());
	}

	public function classNamespace()
	{
		return $this->_classNamespace ;
	}

	public function webPageClass()
	{
		return $this->classNamespace().'\\Page';
	}

	public function formClass()
	{
		return $this->classNamespace().'\\Form';
	}

	public function daoFields( $class )
	{
		if( isset($this->daoMap()[$class]) )
		{
			return $this->daoMap()[$class] ;
		}

		throw new \Exception( 'No Fields Selected For DAO "'.$class.'" ' , 1);
	}

	public function form()
	{
		if( empty($this->_form) )
		{
			$formClass = $this->formClass();
			$this->_form = new $formClass();
		}

		return $this->_form ;
	}

	public function daoMap()
	{
		return [] ;
	}

	public function name()
	{
		return $this->_name ;
	}

	public function key()
	{
		return $this->_key ;
	}

	abstract public function isAccessible();

	public function makePage( $params = [] )
	{
		if($this->isAccessible())
		{
			// $pageClass = $this->webPageClass();
			// return $pageClass::I()->make( $params )
			return $this->page()->make( $params );
		}
	}

	public function page()
	{
		if( empty($this->_page) )
		{
			$pageClass = $this->webPageClass();

			$this->_page = new $pageClass;
		}
		return $this->_page ;
	}

	public function isAccessibleBySU()
	{
		return $this->app()->su()->canAccessContext( $this->module()->key(), $this->name() ) ;
	}

	public function run( $params = [] )
	{
		return $this->makePage( $params ) ;
	}
}
