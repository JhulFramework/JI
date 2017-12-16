<?php namespace _m\pai\context\setup_\_view;

class Form extends \_m\webpage\view\element\form\Form
{
	private $_title;
	private $_description;

	public function setTitle( $title )
	{
		$this->_title = $title;
		return $this ;
	}

	public function setDescription( $description )
	{
		$this->_description = $description ;
		return $this ;
	}

	public function title()
	{
		return $this->_title ;
	}

	public function description()
	{
		return $this->_description ;
	}

}
