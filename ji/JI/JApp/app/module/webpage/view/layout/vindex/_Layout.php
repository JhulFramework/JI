<?php namespace _m\webpage\view\layout\vindex;

abstract class _Layout extends \_m\webpage\view\layout\_Class
{

	public function useStyles()
	{
		return [ 'layout', 'size', 'color' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}

	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}
}
