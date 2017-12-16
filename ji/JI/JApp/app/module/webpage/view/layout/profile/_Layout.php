<?php namespace _m\webpage\view\layout\profile;

class _Layout extends \_m\webpage\view\layout\_Class
{
	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}

	public function useStyles()
	{
		return [ 'responsive', 'typo', 'social', 'color' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}
}
