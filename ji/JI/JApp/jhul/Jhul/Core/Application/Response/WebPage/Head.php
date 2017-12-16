<?php namespace Jhul\Core\Application\Response\WebPage;

class Head
{
	private $_title;

	//boolean
	protected $_indexing = FALSE;

	private $_meta_tags = [] ;

	private $_style;

	public function __construct( $title )
	{
		$this->_title = $title;
	}

	//enable/disable page indexing for search engine robots
	public function setIndexing( $bool )
	{
		$this->_indexing = $bool;
	}


	public function setTitle( $title )
	{
		$this->_title = $title ;
	}

	public function makeTitle()
	{
		return '<title>'.$this->_title.'</title>';
	}

	public function add( $name, $content )
	{
		$this->_meta_tags[$name] = '<meta name="'.$name.'" content="'.$content.'" /> ';
	}

	public function addHttpEquiv( $httpEquiv, $content )
	{
		$this->_meta_tags[$httpEquiv] = '<meta http-equiv="'.$httpEquiv.'" content="'.$content.'" /> ';
	}

	public function metaTags()
	{
		if( FALSE == $this->_indexing )
		{
			$this->add('robots', 'noindex');
		}

		return implode('', $this->_meta_tags) ;
	}

	public function toString()
	{
		return $this->__toString();
	}

	public function __toString()
	{
		return $this->metaTags().$this->makeTitle().$this->style()->toString();
	}

	public function style()
	{
		if( empty($this->_style) )
		{
			$this->_style = new Style;
		}

		return $this->_style;
	}
}
