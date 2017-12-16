<?php namespace _m\webpage\view\layout\article\item\big;


abstract class _Class extends \_m\webpage\view\layout\_Class
{
	public function __construct(  $params = [] )
	{
		$this->setScript( 'voteURL', 'var voteURL = \''. $this->voteURL() .'\'  ;' ) ;

		parent::__construct( $params );
	}

	public function useScripts()
	{
		return [ 'voting' ] ;
	}

	public function useStyles()
	{
		return [ 'style' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}

	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}

	abstract public function voteUrl();
}
