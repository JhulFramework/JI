<?php namespace _m\webpage\view\element\form\field;

class EditText extends _Field
{
	public function initialize()
	{
		if( !$this->hasAttribute('type') )
		{
			$this->setAttribute( 'type', $this->type() );
		}
	}

	public function wrapperClass()
	{
		return 'editTextWrapper';
	}

	public function core()
	{
		/*return $this->makeLabel().'<input'.$this->serializeAttributes().' value="<?= $form->restore(\''.$this->name().'\')?>" /><div class="error"><?= $form->error(\''.$this->name().'\') ?></div>'; */
		return '<div class="inline">'.$this->makeLabel().'<input'.$this->serializeAttributes().' value="<?= $form->restore(\''.$this->name().'\')?>" /></div><div class="error"><?= $form->error(\''.$this->name().'\') ?></div>';
	}

	public function type()
	{
		return 'text' ;
	}
}
