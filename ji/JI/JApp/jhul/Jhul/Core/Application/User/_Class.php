<?php namespace Jhul\Core\Application\User;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:38:41 PM IST
| SINGLETON
| @Update : [ 2016-07-08, 2016-12-20, 2017-01-29 ]
+---------------------------------------------------------------------------------------------------------------------*/
abstract class _Class
{
	use \Jhul\Core\_AccessKey;

	const STORE_LANGUAGE_KEY = 'language' ;

	protected $_session_data = [];

	//Data Access Object
	protected $_DAO;

	private $_user_key;

	//data that only persist during a request;
	private $_data = [];

	abstract public function keyName();

	abstract public function DAOClass();

	abstract public function sessionStoreKey();

	public function __construct()
	{
		$this->loadSession();
		$this->_request = new Request($this->app()->outputMode() );
	}

	private function loadSession()
	{
		if( $this->session()->has( $this->sessionStoreKey() ) )
		{
			$this->_session_data = unserialize($this->session()->get( $this->sessionStoreKey() ));
		}

		if( $this->hasState( $this->keyName() ) )
		{
			$key =  (int) $this->getState( $this->keyName() );

			if( $key > 0 ) $this->_user_key = $key;
		}
	}

	public function key()
	{
		return $this->_user_key;
	}

	public function sessionData()
	{
		return $this->_session_data ;
	}

	public function isWebPageConsumer() { return 'webpage' == $this->request()->mode() ; }

	public function isJSONConsumer() { return 'json' == $this->request()->mode() ; }

	public function login( $user, $rememberMe = FALSE )
	{
		if( NULL == $user->key() ) throw new \Exception (' User ID required for login ');

		$this->session()->regenerateKey();

		$this->setState( $this->keyName(), $user->key()  );

		foreach ( $user->loginStates() as $state )
		{
			$this->setState( $state, $user->$state() );
		}

		if( $this->hasState('go_to_after_login')  )
		{
			$this->app()->redirect( $this->session()->pull('go_to_after_login') );
		}

		return TRUE;
	}

	//TODO logout cookies
	public function logout()
	{
		$this->session()->remove( $this->sessionStoreKey() );
		$this->_session_data = [];
		$this->_user_key = 0 ;
		$this->_DAO = NULL;
	}

	public function isAnon(){ return  $this->key() < 1 ; }

	public function language()
	{
		return $this->hasState( 'language' ) ? $this->getState( 'language' ) : $this->app()->config('language');
	}

	//returns data model of logged in user
	public function DAO()
	{
		if( NULL == $this->_DAO && NULL != $this->key() )
		{
			$class = $this->DAOClass();

			$this->_DAO = $class::D()->byKey( $this->key() )->fetch();
		}

		return $this->_DAO ;
	}

	public function request(){ return $this->_request; }


	public function setLanguage( $value ){ return $this->setState( static::STORE_LANGUAGE_KEY , $value ); }

	//Access session
	public function session() { return $this->app()->session() ; }

	public function has( $key )
	{
		return array_key_exists( $key, $this->_data );
	}

	public function set( $key, $value )
	{
		$this->_data[$key] = $value;
	}

	public function get( $key, $required = TRUE )
	{
		if( isset($this->_data[$key]) ) return $this->_data[$key];

		if( $required ) throw new \Exception( 'Data not set with key "'.$key.'" for current user' , 1);
	}

	public function setState( $key, $value )
	{
		$this->_session_data[$key] = $value;

		$this->session()->set( $this->sessionStoreKey() , serialize( $this->_session_data ) );
	}

	public function hasState( $key )
	{
		return isset($this->_session_data[$key]);
	}

	public function getState( $key )
	{
		if( isset($this->_session_data[$key]) )
		{
			return $this->_session_data[$key];
		}
	}

}
