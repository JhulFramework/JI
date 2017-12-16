<?php namespace Jhul\Component\HTML\Helper\ArrayView;

/* @Author : Manish Dhruw
+=======================================================================================================================
| @Created : 2017NOV1
+---------------------------------------------------------------------------------------------------------------------*/

class Helper
{
	private $_dummyArray = [];

	public function __construct()
	{
		$this->_style = $this->loadCss('main').$this->loadCss('horizontal').$this->loadCss('icons').$this->loadCss('vertical');
	}

	public function loadCss( $name )
	{
		return file_get_contents( __DIR__.'/style/'.$name.'.css' ) ;
	}

	public function toHTML( $array )
	{
		$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' ;

		$html .= '<style>'.$this->_style.'</style>';

		return $html.'<div class="array_view">'.(new _Array( $array ))->toString().'</div>' ;
	}


	public function dummyArray()
	{
		if( empty($this->_dummyArray) )
		{
			$this->_dummyArray = require(__DIR__.'/_dummyArray.php');
		}

		return $this->_dummyArray ;
	}

	public function showDummy()
	{
		return $this->toHTML( $this->dummyArray() ) ;
	}

}
