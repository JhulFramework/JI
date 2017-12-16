<?php namespace Jhul\Component\HTML\Helper\ArrayView;

/* @Author : Manish Dhruw
+=======================================================================================================================
| @Created : 2017NOV1
+---------------------------------------------------------------------------------------------------------------------*/

class _Array
{
	private $_array = [];

	private $_depth = 1;

	private $_itemAsHtml = [];


	private function setDepth( $depth )
	{
		$this->_depth = $depth;

		return $this ;
	}

	public function __construct( $array = [] )
	{
		$this->_array = $array;
	}

	public function depth()
	{
		return $this->_depth ;
	}

	public function containerStyleClass()
	{
		return ($this->_depth % 2) === 0 ? 'horizontal' : 'vertical' ;
	}

	public function isEven()
	{
		return ($this->_depth % 2) === 0 ;
	}


	public function encode( $string )
	{
		return htmlspecialchars( $string, ENT_QUOTES, 'utf-8' ) ;
	}

	public function toString()
	{
		$html = '<div class="'.$this->containerStyleClass().'"><div class="borderStart"></div>';

		foreach ( $this->_array as $key => $value)
		{
			$value = is_array( $value ) ? (new static($value))->setDepth( $this->_depth + 1 )->toString() : $this->encode($value) ;
			$html .= $this->pair( $this->key($key).$this->arrow().$this->value($value) );
		}

		return $html.'<div class="borderEnd"></div></div>';

	}

	//key => value pair
	public function pair( $pair )
	{
		return '<div class="'.$this->styleClass('pair').'">'.$pair.'</div>' ;
	}

	public function key( $key )
	{
		return '<div class="'.$this->styleClass('key').'">'.$key.'</div>' ;
	}

	public function value( $value )
	{
		return '<div class="'.$this->styleClass('value').'">'.$value.'</div>' ;
	}

	public function styleClass( $class )
	{
		return $this->isEven() ? $class.'_h' : $class.'_v';
	}

	public function arrow()
	{
		if( $this->isEven() )
		{
			return '<div class="arrow_v"><i class="icon-down"></i></div>' ;
		}

		return '<div class="arrow_h"><i class="icon-right"></i></div>' ;
	}
}
