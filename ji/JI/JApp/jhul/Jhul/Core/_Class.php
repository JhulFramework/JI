<?php namespace Jhul\Core;

 /* @Author Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
| @Creation-Date Thursday 12 December 2013 04:12:11 PM IST
|
| @API
| - $this->g( $coreComponent ) // getter for Core Components
| - $this->s() //setter
| - $this->com( $componentName )
| - $this->ifDebugOn()
| - ::I() //instance
|
| @Core-Components
| - CX = Component Loader
| - EX = ExceptionHandler
| - FX = FileManager
|
| @Updated -
| - Sun 15 Nov 2015 08:52:28 PM IST
| - Mon 16 Nov 2015 02:24:21 PM IST
| - [2016-Oct-07, 29-Oct-2016]
+---------------------------------------------------------------------------------------------------------------------*/

defined('JHUL_START_TIME') or define('JHUL_START_TIME', microtime( TRUE ));

defined('JHUL_FRAMEWORK_PATH') or define('JHUL_FRAMEWORK_PATH', dirname(dirname(__DIR__) ));

defined('JHUL_IF_ENABLE_DEBUG') or define( 'JHUL_IF_ENABLE_DEBUG', FALSE );

defined('JHUL_DISABLE_FRAMEWORK_ERROR') or define('JHUL_DISABLE_FRAMEWORK_ERROR', FALSE);

defined('JHUL_ENABLE_EX_HANDLER' ) or define('JHUL_ENABLE_EX_HANDLER', TRUE ) ;


abstract class _Class
{

	const REGISTER_KEY = 'jhul_regsiter';

	protected $_baseURL ;

	protected static $I = NULL;

	// @Object : Exception Handler
	protected $_ex;

	// @Object : FileSystem
	protected $_fx;

	// @Object : Component Loader
	protected $_cx;

	protected $_publicRoot ;

	private $_mRegister;

	private $_mSysFileStore;
	private $_mPubFileStore;

	public function app()
	{
		if( empty( $this->_app )  )
		{
			$this->cx()->inject( $this->_app, 'app' );
		}

		return $this->_app;
	}

	public function baseURL()
	{
		return $this->_baseURL ;
	}

	public function cx( $name = NULL )
	{
		if( !empty($name) ) return $this->_cx->get($name);

		return $this->_cx;
	}

	public function ex() { return $this->_ex; }

	public function fx() { return $this->_fx; }

	public static function create( $config )
	{
		if( NULL == static::$I )
		{
			static::$I = new static();
			_Assembler::I()->assemble( static::$I, $config ) ;
			static::$I->registerAutoload();
		}
	}

	public static function I()
	{
		return static::$I;
	}

	static function ifDebugOn()
	{
		return JHUL_IF_ENABLE_DEBUG === TRUE ;
	}

	public function s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
	}

	public function publicRoot()
	{
		return $this->_publicRoot ;
	}

	// public function publicCacheDirectory()
	// {
	// 	return $this->_publicCacheDirectory ;
	// }

	public function mReg()
	{
		return $this->_mRegister;
	}

	public function register()
	{
		return $this->mReg()->get(static::REGISTER_KEY) ;
	}

	public function showError( $error, $params, $entity )
	{
		$this->cx('XHelper')->show( $error , $params, $entity );
	}

	static function timeElapsed()
	{
		return microtime(true) - JHUL_START_TIME ;
	}

	static function autoload( $className )
	{
		$file = static::I()->fx()->getFile( $className );

		if( is_file( $file ) ) require_once( $file );
	}

	public function mSysFileStore()
	{
		return $this->_mSysFileStore ;
	}

	public function mPubFileStore()
	{
		return $this->_mPubFileStore ;
	}

	protected function registerAutoload()
	{
		spl_autoload_register(  [ get_called_class() , 'autoload' ] , true);
	}

}
