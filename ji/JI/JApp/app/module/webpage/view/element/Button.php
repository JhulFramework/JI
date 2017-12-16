<?php namespace _m\webpage\view\element;

class Button extends \_m\webpage\view\_Class
{
	use _HasAttributes;

	private $_p  =
	[
		'content' => 'submit',
	];

	public function set( $key, $value )
	{
		$this->_p[$key] = $value;
		return $this ;
	}


	public function p( $key )
	{
		return $this->_p[$key] ;
	}

	public function wrapperClass()
	{
		return 'buttonWrapper' ;
	}

	public function compileStyle(){}
	public function compileScript(){}

	public function compileContent()
	{
		return '<div class="'.$this->wrapperClass().'"><button>'.$this->p('content').'</button></div>';
	}
}
