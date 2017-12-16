<?php namespace _m\webpage\view\layout\chat\roomlist;

class _Layout extends \_m\webpage\view\type\template\_Class
{
	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}

	public function useStyles()
	{
		return [ 'dimension', 'responsive', 'color' ] ;
	}
}
