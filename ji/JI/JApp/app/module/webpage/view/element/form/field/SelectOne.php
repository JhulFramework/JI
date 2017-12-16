<?php namespace _m\webpage\view\element\form\field;

class SelectOne extends _Field
{
	public function wrapperClass()
	{
		return 'selectOneWrapper';
	}

	private function _options()
	{
		return

		'<?php foreach ($'.$this->name().'Options as $value => $label) : $selected = ($value == $'.$this->name().'SelectedValue) ? \'selected \' : NULL ; ?>
		<option value="<?= $value ?>" <?= $selected ?>><?= $label ?></option>
		<?php endforeach ; ?>
		';

	}

	public function core()
	{
		return '<div class="inline">'.$this->makeLabel().'<select'.$this->serializeAttributes().'>'.$this->_options().'</select></div><div class="error"><?= $form->error(\''.$this->name().'\') ?></div>';
	}

}
