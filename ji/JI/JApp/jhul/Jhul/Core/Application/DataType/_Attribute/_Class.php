<?php namespace Jhul\Core\Application\DataType\_Attribute;

/* @Author : Manish Dhruw [saecoder@gmail.com]
+=======================================================================================================================
| @Created : 2016-July-31
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class implements _Interface
{
	use \Jhul\Core\Containers\_Config;

	//@Object : Attribute Definition
	protected $_definition ;

	//@Object : ErrorCodeManger
	protected $_mErrorCode ;

	public static function I() { return new static(); }

	public function filter( $value  )
	{
		return  $this->make( $value )->isValid() ? $value : NULL  ;
	}



	public function mErrorCode()
	{
		if( empty( $this->_mErrorCode ) )
		{
			$this->_mErrorCode = new ErrorCodeManager( $this->type() );
		}

		return $this->_mErrorCode;
	}

	public function validate( $value )
	{
		return $this->make( $value )->isValid();
	}

	public function validationSteps()
	{

		$validation_steps = $this->config('validation_steps');

	 	$validation_steps = is_string( $validation_steps ) ?  explode(':', $validation_steps) : $validation_steps ;

		$methods = ['validateRequired'];

		foreach ( $validation_steps as $step)
		{
			$methods[] = 'validate'.$step;
		}

		return $methods;

	}

	protected function isRqeuired()
	{
		return 1 == $this->config('required') ;
	}

	protected function validateRequired( $value )
	{
		return 1 == $this->config('required') ? !empty( $value ) : TRUE ;
	}

	public function addParams( $params )
	{
		if( is_string( $params ) )
		{
			$params = ['definition' => $params];
		//	$this->config()->add( 'definition', $params, TRUE );
			//$params = $this->decodeDefinition( $params );
		}



		$this->config()->add( $params, TRUE );

		$this->loadDefinition(); //reloading definition;

		return $this;
	}

}
