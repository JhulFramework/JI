<?php namespace Jhul\Core\Application;

class Application
{
	use \Jhul\Core\Design\Component\_Trait;

	protected $_configLoader;

	// @DataType: Object:
	protected $_client_request;

	protected $_mDataType;

	protected $_user;

	protected $_response;

	//application script path
	protected $_path;

	protected $_mActivity;

	//Handler Maanger
	protected $_mHandler;

	//URL manager
	protected $_mURL;

	//Page Manager
	protected $_mPage;

	protected $_data;

	//protected $_modules = [];

	protected $_session;

	//this method will be called before running application
	protected function beforeRun(){}

	public function __construct( $params  )
	{
		$this->_path = $this->J()->fx()->dirPath( get_called_class() );

		$this->_mHandler	= new Handler\Manager;

		$this->_configLoader	= new ConfigLoader;

		$this->_mDataType = new DataType\Manager;

		//TODO remove it
		$this->_data = new SharedData;

		$this->_mapper = new Mapper;

		//$this->_mURL = new URLManager( $params['url'], $this->J()->fx()->loadConfigFile( $params['url_map'] ) );
	}


	public function configLoader(){ return $this->_configLoader; }

	public function clientRequestRoute()
	{
		if( empty($this->_client_request) )
		{
			$this->_client_request = $this->user()->request()->route() ;
		}

		return $this->_client_request;
	}

	protected $_output_mode;

	public function outputMode()
	{
		if( empty($this->_output_mode) )
		{
			$this->_output_mode = $this->resolveOutputMode();

			if( empty($this->_output_mode) )
			{
				$this->_output_mode = 'webpage';
			}
		}

		return $this->_output_mode;
	}

	protected function resolveOutputMode(){}

	public function lipi(){ return $this->J()->cx('lipi'); }

	public function language(){ return $this->J()->cx('lipi')->currentLanguage(); }

	public function mResource()
	{
		return $this->J()->cx('resource_manager');
	}

	public function mData( ){ return $this->_data; }
	public function name()	{ return $this->config('name') ; }
	public function user()	{ return $this->_user; }

	public function mapper()
	{
		return $this->_mapper;
	}

	public function response()
	{
		if( empty($this->_response) )
		{
			$this->_response = new Response\Response( $this->user()->request()->mode() );
		}

		return $this->_response;
	}


	public function mPage(){ return $this->_mPage; }

	public function mHandler(){ return $this->_mHandler; }

	public function mURL(){ return $this->_mURL; }

	public function path(){ return $this->_path; }

	public function session(){ return $this->_session; }

	public function router(){ return $this->J()->cx('router'); }

	public function pubResURL()
	{
		return $this->url().'/'.$this->pubResDir() ;
	}

	public function pubResDir()
	{
		return $this->config('public_resource_directory') ;
	}

	public function pubResPath()
	{
		return $this->publicRoot().'/'.$this->config('public_resource_directory') ;
	}

	public function pubCacheDir()
	{
		return $this->pubResDir().'/'.$this->config('public_cache_directory');
	}

	public function pubCacheURL()
	{
		return $this->url().'/'.$this->pubCacheDir();
	}

	public function pubCachePath()
	{
		return $this->j()->publicRoot().'/'.$this->pubCacheDir();
	}

	public function m( $name = NULL )
	{
		if( !empty( $name ) )
		{
			return $this->_moduleStore->g( $name );
		}

		return $this->_moduleStore;
	}

	public function context( $context )
	{
		$list = explode( '@', $context );
		return $this->m( $list[0] )->getContext( $list[1] ) ;
	}


	public function mDataType( $type = NULL )
	{
		if( !empty($type))
		{
			return $this->_mDataType->get($type);
		}
		return $this->_mDataType;
	}

	public function mDT( $type = NULL )
	{
		if( !empty($type))
		{
			return $this->_mDataType->get($type);
		}
		return $this->_mDataType;
	}

	public function getFlash( $key = 'flash' )
	{
		return $this->session()->pull( $key );
	}

	public function handleNode( $node )
	{
		return $this->mHandler()->run( $node, TRUE );
	}

	public function hasFlash( $key = 'flash' )
	{
		return $this->session()->has($key);
	}

	protected function resolveClientRequest()
	{

		if( $this->clientRequestRoute()->type() == 'handler' )
		{
			return $this->runHandler( $this->clientRequestRoute()->resource(), $this->clientRequestRoute()->params() );
		}

		if( $this->clientRequestRoute()->type() == 'page' )
		{
			return $this->makePage( $this->clientRequestRoute()->resource() , $this->clientRequestRoute()->params() );
		}

		if( $this->clientRequestRoute()->type() == 'virtual_node' )
		{
			return $this->renderVirtualNode( $this->clientRequestRoute()->resource(), $this->clientRequestRoute()->params() );
		}
	}

	public function redirect( $url )
	{
		header( 'Location: '.$url );
		exit;
	}

	private function registerExceptionHandler()
	{
		// $this->j()->ex()->createCallbackHandler
		// (
		// 	function()
		// 	{
		// 		$this->handleNode('SERVER_ERROR');
		// 		$this->sendResponse();
		// 		return FALSE;
		// 	}
		// );
	}


	public function renderVirtualNode( $route, $params =[] )
	{
		if( is_string($route) )
		{
			$route = $this->M()->mapper()->identifyResource($route);
		}

		$this->renderFile( $this->m( $route->moduleKey() )->path().'/virtual_node/'.$route->target().'.php' , $params );
	}

	public function renderFile( $file, $params =[] )
	{
		if( !$this->J()->ifDebugOn() )
		{
			$this->registerExceptionHandler();
		}

		$this->beforeRun();


		$this->response()->page()->loadFile( $file , $params );
	}

	public function initializeWebpage(){}

	public function run()
	{
		if( !$this->J()->ifDebugOn() )
		{
			$this->registerExceptionHandler();
		}

		$this->beforeRun();

		if( $this->outputMode() == 'webpage' )
		{
			$this->initializeWebpage();
		}

		$this->resolveClientRequest();

		$this->response()->setStatusCode( $this->user()->request()->route()->statusCode() );


		if( $this->response()->isEmpty() )
		{ob_clean();
		echo '<pre>';
		echo '<br/> File : <br/>'.__FILE__.':'.__LINE__.'</br></br>';
		var_dump('break');
		echo '</pre>';
		exit();
			$this->makePage( 'main@error404' );
		}

		return $this->response()->send();
	}

	public function getContext( $context )
	{
		$slug = explode('@', $context);

		return $this->m($slug[0])->getContext( $slug[1] ) ;
	}

	//@param : $context = module@context
	public function makePage( $context, $params = [] )
	{
		$this->getContext($context)->makePage( $params );
	}

	//@param : $handler = can be NAME CLASS or PAGE NAME( [module][pageIdentifier][page] )
	public function runHandler( $handler, $params = [] )
	{
		return $this->mHandler()->run( $handler , $params );
	}

	public function s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
	}

	public function sysCachePath()
	{
		return JHUL_SERVER_CACHE_DIRECTORY;
	}


	public function setFlash( $value, $key = 'flash' )
	{
		$this->session()->set( $key, $value );
	}

	public function url( $append = NULL )
	{
		if( !empty($append) )
		{
			return $this->j()->baseURL().'/'.$append;
		}

		return $this->j()->baseURL();
	}


	//file cache maanager
	private $_mSysCache ;

	public function mSysCache()
	{
		if( empty($this->_mSysCache)  )
		{
			$this->_mSysCache = new FileCache( $this->J()->dataStoreDirectoryPath().'/'.$this->_key() );
		}

		return $this->_mSysCache;
	}

	//file cache maanager
	private $_mPubCache ;

	public function mPubCache()
	{
		if( empty($this->_mPubCache)  )
		{
			$this->_mPubCache = new FileCache( $this->pubCachePath() );
		}

		return $this->_mPubCache;
	}

}
