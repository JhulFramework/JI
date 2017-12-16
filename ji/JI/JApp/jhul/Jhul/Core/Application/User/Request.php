<?php namespace Jhul\Core\Application\User;

/*
| @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created :Thursday 06 February 2014 10:37:57 AM IST
| @Updated : [ 2017-01-29]
+---------------------------------------------------------------------------------------------------------------------*/

class Request
{
	use \Jhul\Core\_AccessKey;


	protected $_baseURI ;

	protected $path;

	protected $_route;

	public  $autoDetectBaseURL = TRUE;

	public function __construct( $mode )
	{
		$this->translateURL();

		$this->_mode = $mode;
	}

	public function setBaseURI( $baseURI )
	{
		$this->_baseURI = trim( $baseURI, '/' );
	}

	public function baseURI()
	{
		return $this->_baseURI;
	}

	public function path(){ return $this->path; }

	public function route()
	{
		if( empty($this->_route) )
		{
			$this->_route =  new Route(  \Jhul::I()->cx('router')->match( $this->path() ) );
		}

		return $this->_route;
	}

	public function translateURL()
	{
		if( $this->autoDetectBaseURL )
		{
			$info = parse_url( $this->J()->baseURL() )  ;

			if(!empty($info['path']))
			{
				$this->_base_url = trim( $info['path'], '/' );
			}
		}

		if( NULL == $this->path  )
		{
			$uri =  trim($_SERVER['REQUEST_URI'], '/') ;


			if( !empty($this->_base_url) && 0 === strpos( $uri, $this->_base_url ) )
			{
				$uri = substr( $uri, strlen($this->_base_url) + 1  );
			}

			$this->path = trim( $uri, '/') ;

			if( FALSE !== ( $pos = mb_strpos( $this->path, '?' ) ) )
			{
				$this->path = mb_substr( $this->path, 0, $pos );
			}
		}
	}

	public function mode() { return $this->_mode; }

	public function hasQuery( $key , $value )
	{
		return isset($_GET[$key] ) && $value === $_GET[$key] ;
	}

	public function hasQueryDataType( $key , $data_type )
	{
		if( isset($_GET[$key] ) )
		{
			return $this->app()->mDataType( $data_type )->make( $_GET[$key] )->isValid() ;
		}

		return FALSE;
	}

}
