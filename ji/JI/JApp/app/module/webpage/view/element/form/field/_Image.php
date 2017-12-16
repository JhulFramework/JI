<?php namespace _m\webpage\view\element\form\field;

abstract class _Image extends _Field
{
	public function __construct()
	{
		parent::__construct();
	}

	public function initialize()
	{
		if( !$this->hasAttribute('type') )
		{
			$this->setAttribute( 'type', $this->type() );
		}
	}

	public function wrapperClass()
	{
		return 'imageFieldWrapper';
	}

	public function core()
	{
		return $this->makeLabel().'<input'.$this->serializeAttributes().' /><div class="error"><?= $form->error(\''.$this->name().'\') ?></div>';
	}

	public function type()
	{
		return 'file' ;
	}
}
