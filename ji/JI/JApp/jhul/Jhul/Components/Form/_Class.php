<?php namespace Jhul\Components\Form;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Updated:
| -Saturday 03 January 2015 07:01:22 PM IST
| -Saturday 10 January 2015 03:54:05 PM IST
| -Tuesday 16 June 2015 01:23:44 PM IST
| - [ 2017-01-31 ]
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{
	use \Jhul\Core\_AccessKey;

	private $_mField ;
	private $_mFile ;

	public function mField()
	{
		return $this->_mField;
	}

	public function mFile()
	{
		return $this->_mFile;
	}

	abstract function name();

	public function fields() { return []; }

	//we will auto create properties which are defined in field definitions;
	public function __construct()
	{

		$this->reloadFieldManager();
		$this->_submission = new Submission();
	}

	public function reloadFieldManager()
	{
		$this->_mField = new FieldManager( $this->loadFields( $this->fields() ) ) ;
		$this->_mFile = new FieldManager( $this->loadFields( $this->files() ) ) ;
	}

	private function loadFields( $requireFields )
	{
		$definitionMap = $this->J()->fx()->loadConfigFile( $this->domain()->path().'/_config/_form_fields');

		$fields = [];

		foreach ( $this->fields() as $field  )
		{
			$fields[$field] = $definitionMap[$field];
		}

		return $fields;
	}

	public function fieldValue( $field )
	{
		return isset( $_POST[ $this->name() ][ $field ] ) ?  $_POST[ $this->name() ][ $field ] : NULL ;
	}

	public function isSubmitted()
	{
		return $this->ifFILESSubmitted() && $this->ifPOSTSubmitted() ;
	}


	public function ifPOSTSubmitted()
	{
		if( [] == $this->mField()->keys() ) return TRUE;

		if( !isset($_POST[$this->name()]) ) return FALSE ;

		$submission = $_POST[$this->name()];

		foreach( $this->mField()->dataTypeMap() as $name => $type )
		{
			$value =  array_key_exists( $name, $submission ) ? $submission[$name] : NULL ;

			$this->clearError($name);

			$this->set( $name, $value, $type );

			$this->addError( $name, $this->submission()->get($name)->errors() );
		}

		return TRUE ;
	}

	public function ifFilesSubmitted()
	{
		if( [] == $this->mFile()->keys() ) return  TRUE;

		if ( empty($_FILES) ) return FALSE ;

		$submission = $_FILES;

		foreach( $this->mFile()->dataTypeMap() as $name => $type )
		{
			$value =  array_key_exists( $name, $submission ) ? $submission[$name] : NULL ;

			$this->clearError($name);

			$this->set( $name, $value, $type );

			$this->addError( $name, $this->submission()->get($name)->errors() );
		}

		return TRUE ;
	}

	public function set( $field , $value, $dataType )
	{
		$this->submission()->set( $field, $this->app()->mDataType( $dataType )->make( $value ) );
		return $this;
	}

	public function get( $field, $required = TRUE )
	{
		if( $this->submission()->has($field) )
		{
			return $this->submission()->get( $field );
		}

		if( $required ) throw new \Exception( 'Field "'.$field.'" Not Set ' , 1);

	}

	public function getAsString( $field, $required = TRUE )
	{
		if( $this->submission()->has($field) )
		{
			return $this->submission()->get( $field )->value();
		}

		if( $required ) throw new \Exception( 'Field "'.$field.'" Not Set ' , 1);
	}

	public function submission() { return $this->_submission ; }

	public function submittedData()
	{
		return $this->submission()->data() ;
	}

	public function files(){ return [] ; }

	//returns HTML form field name
	public function fieldName( $field )
	{
		return $this->name().'['.$field.']';
	}

	//Restores client sumitted data, to avoid refilling the form
	public function restore( $key )
	{
		if( isset( $_POST[ $this->name() ] ) && isset( $_POST[ $this->name() ][ $key ] ) )
			return $this->html()->encode( $_POST[ $this->name() ][ $key ] );
	}


	public function mDataType( $type )
	{
		return $this->app()->mDataType( $type ) ;
	}



/* BRUTE FORCE DEFENSE
+=====================================================================================================================*/

	// protected $_captcha;
	//
	// public function authAttempts( $userKey ) { return $this->J()->cx( 'bfd' )->get( $userKey , $this->name() ); }
	//
	// public function captcha()
	// {
	// 	if( NULL == $this->_captcha )
	// 	{
	// 		$this->_captcha = new Captcha( $this );
	// 	}
	//
	// 	return $this->_captcha;
	// }
	//
	// public function onAuthorizationFail( $UIK )
	// {
	// 	$this->authAttempts( $UIK )->register()->commit();
	//
	// 	if( $this->authAttempts( $UIK )->countAttempts()  > 12 )
	// 	{
	// 		$this->captcha()->activate();
	// 	}
	// }
	//
	// public function onAuthorizationSuccess( $UIK )
	// {
	// 	$this->captcha()->deactivate();
	// 	$this->authAttempts( $UIK )->clear()->commit();
	// }
	//
	// public function validateCaptcha()
	// {
	// 	if( $this->captcha()->isActive() )
	// 	{
	// 		if( !$this->captcha()->validate() )
	// 		{
	// 			$this->addError( $this->captcha()->name(), 'ERROR_CAPTCHA_CODE_FAILED' );
	// 		}
	// 	}
	// }

/* BRUTE FORCE DEFENSE
+---------------------------------------------------------------------------------------------------------------------*/


/* ERRORS
+=====================================================================================================================*/

	protected $_errors = [] ;

	public function hasError( $attrib = NULL )
	{
		if($attrib != NULL) return isset( $this->_errors[$attrib] );

		return !empty($this->_errors) ;
	}

	//check if for field is submitted
	public function hasSubmitted( $field )
	{
		if( isset($_POST[$this->name()]) )
		{
			return array_key_exists( $field, $_POST[$this->name()] );
		}
	}

	public function error( $attribute )
	{
		return isset( $this->_errors[$attribute] ) ? $this->_errors[$attribute][0] : null ;
	}

	public function errors( $attribute = NULL  )
	{
		if( $attribute != NULL )
		{
			return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : [] ;
		}

		return $this->_errors;
	}

	public function clearError( $field )
	{
		unset($this->_errors[$field]);
	}

	// add muliple erros for single field
	public function addError($attribute, $error )
	{
		if( is_array($error) )
		{
			foreach ($error as $e)
			{
				$this->addError( $attribute, $e );
			}

			return ;
		}

		if( !isset($this->_errors[$attribute] ) ) $this->_errors[$attribute] = array();

		$this->_errors[$attribute][] = $this->translate($error) ;
	}

/* ERRORS
+---------------------------------------------------------------------------------------------------------------------*/

	public function html() { return $this->J()->cx('html'); }

/* TOKEN
+=====================================================================================================================*/

	protected $_token ;

	//name of token
	protected $_tokenFieldName = '_token';

	public function token()
	{
		if( NULL == $this->_token )
		{
			$this->_token = new Token( $this->name(), $this->fieldName( $this->_tokenFieldName ) );
		}

		return $this->_token;
	}

	public function verifyToken()
	{
		if( isset( $_POST[ $this->name() ][ $this->_tokenFieldName ] )  )
		{
			return $this->token()->verify( $_POST[ $this->name() ][ $this->_tokenFieldName ]  );
		}

		return FALSE;
	}

	public function tokenField()
	{
		return '<input type="hidden" name="'.$this->name().'['.$this->_tokenFieldName.']" value="'.$this->token().'" />' ;
	}

/* TOKEN
+---------------------------------------------------------------------------------------------------------------------*/


/* TRANSLATION
+=====================================================================================================================*/

	protected $_strings = [];

	public function string( $key )
	{
		if( empty( $this->_strings ) )
		{
			$this->_strings = $this->translate( $this->stringKeys() );
		}

		return isset( $this->_strings[$key] ) ? $this->_strings[$key] : $key ;
	}

	protected function stringKeys(){ return []; }

	public function translate( $string ){ return $this->app()->lipi()->t( $string ); }

/* TRANSLATION
+---------------------------------------------------------------------------------------------------------------------*/

	protected function preValidate(){}

	protected $_validated = FALSE;

	public final function validate()
	{
		if( !$this->_validated )
		{
			$this->_validated = TRUE;
			$this->preValidate();
			//$this->validateCaptcha();
			$this->postValidate();
		}

		return !$this->hasError();
	}

	protected function postValidate(){}
}
