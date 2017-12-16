<?php namespace _m\webpage\view\type\element;


class Element extends  \_m\webpage\view\_Class implements _Interface
{

	use _API;


	private $_parent = NULL;

	private $_mStyle;

	private $_childrens = [];

	private $_serializedContent;

	public function __construct( $name, $content = '' )
	{
		parent::__construct($name);
		$this->setContent( $content );
	}

	public function mStyle()
	{
		if( empty($this->_mStyle) )
		{
			$this->_mStyle = new _style\Style( $this->key() );
		}

		return $this->_mStyle;
	}

	//add child
	public function add( $key, $content )
	{
		//don not call new static(), cyclic redundncy
		$child = (new Element( $key, $content))->setParent($this);
		$child->mStyle(); // childrens must initializ style, to position itself correctly
		$this->_childrens[$key] = $child;

		return $this ;
	}

	public function addLink( $key, $content )
	{
		//don not call new static(), cyclic redundancy
		$this->_childrens[$key] = (new Link( $key, $content))->setParent($this);

		return $this ;
	}

	public function child($key)
	{
		if( isset($this->_childrens[$key]) )
		{
			return $this->_childrens[$key] ;
		}

		throw new \Exception( 'Child View "'.$key.'" Not Found!' , 1);
	}

	final public function key()
	{
		if( NULL != $this->parent() )
		{
			return $this->parent()->key().'_'.$this->name() ;
		}

		return $this->name() ;
	}

	public function compileContent()
	{

		$content = '';

		if( !empty($this->_childrens) )
		{
			$this->setContent( '' );
		}

		foreach ( $this->_childrens as $child )
		{
			$content .= $child->compileContent();
		}

		if( !empty($this->_mStyle) )
		{
			$content = $this->mStyle()->wrapContent( $content );
		}

		return $content ;
	}

	public function compileStyle()
	{
		$style = '';

		if(!empty($this->_mStyle))
		{
			$style = $this->mStyle()->toString();
		}

		foreach ( $this->_childrens as $child )
		{
			$style .= $child->compileStyle();
		}

		return $style ;
	}

	public function compileScript(){}

	public function parent()
	{
		return $this->_parent ;
	}

	public function setParent( $parent )
	{
		$this->_parent = $parent;
		return $this ;
	}
}
