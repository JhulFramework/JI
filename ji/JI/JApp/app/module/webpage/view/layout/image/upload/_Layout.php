<?php namespace _m\webpage\view\layout\image\upload;

abstract class _Layout extends \_m\webpage\view\layout\_Class
{
	public function resourcePath()
	{
		return __DIR__.'/res' ;
	}

	public function useTemplates()
	{
		return ['body'] ;
	}

	public function useScripts()
	{
		return [ 'script'] ;
	}

	public function useStyles()
	{
		return [ 'style'] ;
	}
}
