<?php namespace _m\webpage\view\element\form\field;

abstract class _Field extends \_m\webpage\view\_Class
{
	use \_m\webpage\view\element\_HasAttributes;

	private $_p  = [];

	public function set( $key, $value )
	{
		$this->_p[$key] = $value;
		return $this ;
	}


	protected function initialize(){}

	private function _make()
	{
		if( !$this->hasP('name') )
		{
			throw new \Exception( 'Field Name Not Set ! use set( \'name\', $name )', 1);
		}

		$nameAttribute = $this->hasP('form_name') ?  ( $this->p('form_name').'['.$this->p('name').']' ) : $this->p('name');

		$this->setAttribute('name', $nameAttribute );

		if( $this->hasP('id') )
		{
			$this->setAttribute('id', $this->p('name') );
		}
	}

	public function compileScript(){}
	public function compileStyle(){}

	public function compileContent()
	{
		$this->_make();
		return '<div class="'.$this->wrapperClass().'">'.$this->core().'</div>';
	}

	public function hasP( $key )
	{
		return isset($this->_p[$key]) ;
	}

	public function p( $key )
	{
		return $this->_p[$key] ;
	}

	public function name()
	{
		return $this->p('name') ;
	}

	protected function makeLabel()
	{
		if( $this->hasP('label')  )
		{
			$for = '';

			if( $this->hasP('id') )
			{
				$for = 'for="'.$this->p('id').'" ';
			}

			return '<label '.$for.' >'.$this->p('label').'</label>';
		}
	}
	public abstract function wrapperClass();
}
