<?php namespace _m\webpage\view\type\element;


class Link extends Element
{

	private $_url = '';

	public function setURL( $url )
	{
		$this->_url = $url;
		return $this ;
	}

	public function content()
	{
		return '<a href="'.$this->_url.'" >'.parent::content().'</a>' ;
	}

}
