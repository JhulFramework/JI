<?php namespace _m\webpage\view\layout\titlebar;

abstract class _Class extends \_m\webpage\view\layout\_Class
{
	public function __construct()
	{
		$this->setPadding();
		$this->addView( 'title', $this->title() );
		$this->addView( 'backURL', $this->backURL() );
	}

	public function useStyles()
	{
		return [ 'style' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}

	abstract public function title();
	abstract public function backURL();

	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}
}
