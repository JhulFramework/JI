<?php namespace _m\webpage\view\element\form\field;

class Token extends _Field
{

	public function __construct( $form_name )
	{
		$name =  !empty($form_name) ? $form_name.'['.$this->name().']' : $this->name() ;

		$this->setAttribute( 'name', $name );
		$this->setAttribute( 'value', '<?= $form->token()->value() ?>' );
		$this->setAttribute( 'type', 'hidden' );
	}

	public function toString()
	{
		return '<input'.$this->serializeAttributes().' />';
	}

	public function wrapperClass()
	{

	}

	public function label()
	{

	}

	public function name()
	{
		return '_token' ;
	}
}
