<?php namespace _m\webpage\view\element\form\field;

class EditTextBig extends _Field
{
	public function wrapperClass()
	{
		return 'editTextBigWrapper';
	}

	public function core()
	{
		return $this->makeLabel().'<textarea'.$this->serializeAttributes().'><?= $form->restore(\''.$this->name().'\') ?></textarea><?= $form->error(\''.$this->name().'\') ?>';
	}
}
