<?php namespace app;

class App extends \Jhul\Core\Application\Application
{

	protected function beforeRun()
	{
		$this->lipi()->setCurrentLanguage( $this->user()->language() );
	}

	protected function resolveOutputMode()
	{
		if( isset( $_GET['mode'] ) && $_GET['mode'] == 'json' )
		{
			return 'json' ;
		}
	}
}
