<?php namespace Jhul\Core\Application\DataType\Types\String;

/* @Author : Manish Dhriuw [1D3N717Y12@gmail.com]
+=======================================================================================================================
|@Created : 2016-July-24
+---------------------------------------------------------------------------------------------------------------------*/


class Attribute extends \Jhul\Core\Application\DataType\_Attribute\_Class
{

	public function charSet()
	{
		return 'utf-8' ;
	}


	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	public function __construct()
	{
		$this->mErrorCode()->add
		([
			'validateExactLength'	=> 'EXACT_LENGTH_FAILED',
			'validateMaxLength'	=> 'MAX_LENGTH_FAILED',
			'validateMinLength'	=> 'MIN_LENGTH_FAILED',
			'validateType'		=> 'TYPE_FAILED',
		]);


		$this->config()->add
		([
			'definition'		=>  'L=1-8000',
			'required'			=> TRUE,
			'validation_steps'	=> 'type:minLength:maxLength',
		]);

		$this->loadDefinition();
	}

	public function loadDefinition()
	{
		$this->config()->add( $this->decodeDefinition( $this->config('definition')  ), TRUE );
	}

	public function decodeDefinition( $definition )
	{
		return Definition::decode( $definition );
	}

	public function make( $value_string  )
	{

		$class = $this->valueEntityClass();

		$value = new $class( $value_string, $this );

		if( FALSE == $this->validateRequired($value_string) )
		{
			$value->addError( 'VALUE_FAILED' );
		}

		if( empty($value_string) ) return $value ;

		$vMethods = $this->validationSteps();

		foreach ( $vMethods as $vMethod )
		{
			if( FALSE == $this->$vMethod( $value_string ) )
			{
				$value->addError( $this->mErrorCode()->get( $vMethod ) );

				return $value;
			}
		}

		return $value;
	}

	public function validateMaxLength( $value )
	{
		if( $this->config()->has('max_length') )
		{
			return mb_strlen( $value, $this->charSet() ) <=  $this->config('max_length') ;
		}

		return TRUE;

	}

	public function validateMinLength( $value )
	{

		if( $this->config()->has('min_length') )
		{
			return mb_strlen( $value, $this->charSet() ) >= $this->config('min_length') ;
		}

		return TRUE;
	}

	public function validateExactLength( $value )
	{
		if( $this->config()->has('exact_length') )
		{
			return mb_strlen( $value, $this->charSet() ) == $this->config('exact_length') ;
		}
		return TRUE;
	}

	public function validateType( $value )
	{
		return is_string( $value );
	}

	public function type(){ return 'string'; }

}
