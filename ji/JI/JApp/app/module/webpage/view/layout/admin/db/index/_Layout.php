<?php namespace _m\webpage\view\layout\admin\db\index;

abstract class _Layout extends \_m\webpage\view\layout\_Class
{

	public function useStyles()
	{
		return [ 'style' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}


	public function resourcePath()
	{
		return __DIR__.'/res' ;
	}
}
