<?php namespace _m\webpage\view\layout\pagination;

abstract class _Class extends \_m\webpage\view\layout\_Class
{
	public function __construct()
	{
		$this->setView( 'previous_button_content', $this->previousButtonContent() );

		$this->setView( 'next_button_content', $this->nextButtonContent() );

		$this->make();
	}

	public function useStyles()
	{
		return [ 'style' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}

	abstract public function previousButtonContent();

	abstract public function nextButtonContent();

	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}
}
