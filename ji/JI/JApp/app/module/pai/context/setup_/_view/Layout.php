<?php namespace _m\pai\context\setup_\_view;

class Layout extends \_m\webpage\view\type\template\_Class
{
	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}

	public function useScripts()
	{
		return [] ;
	}

	public function useTemplates()
	{
		return [ '_layout' ]  ;
	}

	public function useStyles()
	{
		return [ 'style' ]  ;
	}

}
