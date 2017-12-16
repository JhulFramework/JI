<?php namespace Jhul\Core\Application\Response\WebPage;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|
| @ Updated-
| - Saturday 18 April 2015 05:22:09 PM IST
| - Mon 16 Nov 2015 08:46:36 PM IST, [2016-Oct-17, 2016-Nov-05 ]
| - [ 09072017 ]
+---------------------------------------------------------------------------------------------------------------------*/
class WebPage
{
	use \Jhul\Core\_AccessKey;

	private static $_mBreadCrumb;

	protected $_ifUseLayout = TRUE;

	private $_layout;

	protected $_body;
	protected $_head;

	//template manager
	protected $_m_template;

	public function contentTypeHeader() { return 'text/html; charset=utf-8'; }

	public function setUseLayout( $bool )
	{
		$this->_ifUseLayout = $bool;

		return $this;
	}

	public function __construct()
	{
		$this->_layout = new Layout ;
	}

	public function layout()
	{
		return $this->_layout ;
	}

	public function mBreadCrumb()
	{
		if( NULL == self::$_mBreadCrumb )
		{
			self::$_mBreadCrumb = MBreadCrumb::I();
		}

		return self::$_mBreadCrumb;
	}


	/* Elements Access
	+===============================================================================================================*/

	private $_m_image;

	//Image Manager
	public function mImage()
	{
		if( empty($this->_m_image) )
		{
			$this->_m_image = new Image;
		}
		return $this->_m_image;
	}


	public function script()
	{
		return $this->body()->script();
	}

	//Style(CSS) Manager
	public function style()
	{
		return $this->head()->style() ;
	}

	public function type()
	{
		return 'webpage';
	}

	public function mTemplate()
	{
		if(empty($this->_m_template))
		{
			$this->_m_template = new Template;
		}
		return $this->_m_template;

	}

	public function body()
	{
		if(empty($this->_body))
		{
			$this->_body = new Body;
		}
		return $this->_body;

	}

	public function head()
	{
		if(empty($this->_head))
		{
			$this->_head = new Head( $this->app()->name() );
		}

		return $this->_head;
	}


	/* Page indexing
	+===============================================================================================================*/


	//enable/disable page indexing for search engine robots
	public function enableIndexing()
	{
		$this->head()->setIndexing(TRUE);
	}

	public function disableIndexing()
	{
		$this->head()->setIndexing(FALSE);
	}


	public function setTitle( $title )
	{
		$this->head()->setTitle( $title );
	}

	/*--------------------------------------------------------------------------------------------------------------*/

	public function isEmpty()
	{
		return !$this->body()->isEmpty();
	}

	public function loadFile( $file, $params = [] )
	{
		$this->addContent( $this->mTemplate()->buffer($file.'.php', $params) );
	}

	public function addContent( $content )
	{
		$this->body()->add( $content);
	}

	public function cook( $view, $params = [] )
	{
		$this->addContent( $this->mTemplate()->load( $view, $params ) ) ;
	}

	public function make()
	{
		if( !$this->_ifUseLayout ) return  $this->body()->get('content') ;

		foreach ( $this->layout()->map() as $name => $view)
		{
			$this->body()->set($name, $this->mTemplate()->load( $view ) );
		}

		$params =
		[
			'body'		=> $this->body(),

			'head' 		=> $this->head()->toString(),

			'script'		=> $this->script()->toString(),
		];

		return $this->mTemplate()->load( 'main.layout', $params );
	}


	public function __toString()
	{
		return $this->make();
	}
}
