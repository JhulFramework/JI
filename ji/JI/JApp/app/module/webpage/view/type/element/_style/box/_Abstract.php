<?php namespace _m\webpage\view\type\element\_style\box;

abstract class _Abstract
{
	protected $_styles = [];

	protected $_viewKey;

	public function __construct( $viewKey )
	{
		$this->_viewKey = $viewKey;
	}

	public function set( $key, $value )
	{
		$this->_styles[$key] = $value;
	}

	public function toString()
	{
		$style = '';

		foreach ( $this->_styles as $key => $value)
		{
			$style .= $key.':'.$value.';';
		}

		return  '.'.$this->key().'{'.$style.'}' ;
	}

	abstract public function name();

	public function key()
	{
		return $this->viewKey().'_'.$this->name() ;
	}

	public function viewKey()
	{
		return $this->_viewKey ;
	}

	public function setBackground( $color)
	{
		return $this->set('background', $color);
	}
}
