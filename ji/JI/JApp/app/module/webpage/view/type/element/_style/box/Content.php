<?php namespace _m\webpage\view\type\element\_style\box;

class Content extends _Abstract
{
	public function __construct( $param )
	{
		parent::__construct($param);
		$this->set('display', 'flex');
		$this->set('justify-content', 'left');
		$this->set('align-self', 'center');

	}

	public function name()
	{
		return  'content' ;
	}
}
