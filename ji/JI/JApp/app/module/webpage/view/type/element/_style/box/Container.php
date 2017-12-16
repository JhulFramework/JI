<?php namespace _m\webpage\view\type\element\_style\box;

class Container extends _Abstract
{
	public function __construct( $param )
	{
		parent::__construct($param);
		$this->set('display', 'flex');
		$this->set('justify-content', 'center');
	}

	public function name()
	{
		return  'container' ;
	}
}
