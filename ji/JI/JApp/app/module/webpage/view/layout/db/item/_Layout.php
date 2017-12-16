<?php namespace _m\webpage\view\layout\db\item;

/* @Author : Manish Dhruw
+=======================================================================================================================
| @Created : 2017Oct
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Layout extends \_m\webpage\view\layout\_Class
{

	private $_formView;

	public function __construct( $formView, $make = TRUE )
	{
		$this->_formView = $formView;

		if($make)
		{
			$this->make();
		}
	}

	public function formView()
	{
		return $this->_formView ;
	}

	public function useStyles()
	{
		return [ 'style', 'form' ] ;
	}

	public function useTemplates()
	{
		return [ 'body' ] ;
	}


	public function resDirPath()
	{
		return __DIR__.'/res' ;
	}

	public function make()
	{
		$form = '';

		foreach ($this->formView()->fields() as $key => $type )
		{
			$this->formView()->addFieldByKey( $key, $type );
		}

		$this->formView()->addButton( 'button', 'Save');

		//$form .= $this->builder()->makeView( $this->resDirPath().'/form.php', [ 'form' => $this->formView()->toString(), 'field' => $key ] ) ;


		$this->setView('form', $this->formView()->toString() );

		parent::make();

	}
}
