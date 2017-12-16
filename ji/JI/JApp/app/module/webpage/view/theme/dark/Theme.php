<?php namespace _m\webpage\view\theme\dark;

class Theme
{
	private $_styles =
	[
		'form' => 'form/style',
	];

	public function has( $name )
	{
		return isset($this->_styles[$name]);
	}

	public function getCode( $name)
	{
		return file_get_contents( $this->getFile($name) );
	}

	public function getFile( $name)
	{
		if( isset( $this->_styles[ $name ] ) )
		{
			return __DIR__.'/'.$this->_styles[$name].'.css';
		}
	}

	public function asHtml( $name )
	{
		return '<style type="text/css" >'.$this->getCode($name).'</style>';
	}
}
