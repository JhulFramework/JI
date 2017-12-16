<?php namespace Jhul\Core\Application\DataType\Types\Email ;

class Attribute extends \Jhul\Core\Application\DataType\Types\String\Attribute
{

	public function __construct()
	{
		parent::__construct();

		$this->mErrorCode()->add( 'validateHost', 'HOST_FAILED' );
		$this->config()->add
		([
			'if_validate_host' => FALSE,
			'validation_steps' => 'type:minLength:maxLength:host',
		], TRUE);
	}


	public function allowedHosts()
	{
		return $this->config('allowed_hosts') ;
	}

	public function type(){ return 'email' ; }

	public function prepareValue( $value ) { return $value; }

	public function validateType ( $value )
	{
		return filter_var( $value, FILTER_VALIDATE_EMAIL ) ;
	}

	public function validateHost( $value )
	{

		if( TRUE == $this->config('if_validate_host', FALSE) )
		{
			$host = substr( $value , strpos( $value, '@') + 1   );

			$host = strtolower($host);

			return in_array( $host, $this->allowedHosts() ) ;
		}

		return TRUE;
	}
}
