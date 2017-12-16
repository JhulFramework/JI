<?php namespace _m\webpage\view\layout\admin\db\item;

abstract class _Layout extends \_m\webpage\view\layout\_Class
{

	//form datamodel
	private $_formDM;

	private $_formView;

	public function __construct( $formDataModel, $make = TRUE )
	{
		$this->_formDM = $formDataModel;

		if($make)
		{
			$this->make();
		}
	}

	public function formDM()
	{
		return $this->_formDM ;
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


	public function resourcePath()
	{
		return __DIR__.'/res' ;
	}

	public function make()
	{
		$form = '';

		foreach ($this->formDM()->mField()->fields() as $key => $info )
		{
			$fieldView = $info['view'];

			$formClass = $this->formClass();

			$formView = new $formClass( $this->formDM()->name() );

			$formView->addField( new $fieldView() );

			$formView->addButton('Save');

			$form .= $this->builder()->makeView( $this->resourcePath().'/form.php', [ 'form' => $formView->toString(), 'field' => $key ] ) ;
		}

		foreach ($this->formDM()->mFile()->fields() as $key => $info )
		{
			$fieldView = $info['view'];

			$formClass = $this->formClass();

			$formView = new $formClass( $this->formDM() );

			$formView->addField( new $fieldView($this->formDM()->name()) );

			$formView->addButton('Save');

			$form .= $this->builder()->makeView( $this->resourcePath().'/form.php', [ 'form' => $formView->toString(), 'field' => $key ] ) ;
		}


		$this->set('form', $form);

		parent::make();

	}

	public function formClass()
	{
		return  '\\_m\\webpage\\view\\element\\form\\Form';
	}
}
