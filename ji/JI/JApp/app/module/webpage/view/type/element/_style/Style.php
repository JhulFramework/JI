<?php namespace _m\webpage\view\type\element\_style;

/* @Author: Manish Dhruw
+=======================================================================================================================
| @Created : 2017Nov01
+---------------------------------------------------------------------------------------------------------------------*/

class Style
{
	private $_name  ;

	private $_content;
	private $_container;

	public function __construct( $name )
	{
		$this->_name	= $name;
		$this->_container = new box\Container($this->_name);
		$this->_content 	= new box\Content($this->_name);
	}

	public function container()
	{
		return $this->_container ;
	}

	public function content()
	{
		return $this->_content ;
	}

	public function setBackground( $color )
	{
		$this->container()->set( 'background', $color);
		return $this ;
	}


	public function setWidthFULL()
	{
		$this->container()->set('display', 'block');
		return $this ;
	}

	public function setClassName( $name )
	{
		$this->_name = $name;
		return $this ;
	}

	public function name()
	{
		return $this->_name ;
	}

	public function wrapContent( $content )
	{
		return '<div class="'.$this->container()->key().'" ><div class="'.$this->content()->key().'" >'.$content.'</div></div>' ;
	}

	public function toString()
	{
		return $this->container()->toString().$this->content()->toString() ;
	}

}
