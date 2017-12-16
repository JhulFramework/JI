<?php namespace _m\webpage\view\layout\admin\db\add;

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
		$formClass = $this->formClass();

		$formView = new $formClass( $this->formDM()->name() );

		$formView->setTitle( 'Add Item In DB Table'  );

		foreach ($this->formDM()->mField()->fields() as $key => $info )
		{
			$fieldView = $info['view'];

			$formView->addField( new $fieldView() );

			//$form .= $this->builder()->makeView( $this->resourcePath().'/form.php', [ 'form' => $formView->toString(), 'field' => $key ] ) ;
		}

		$formView->addButton('Create');

		$this->set('form', $formView->toString());

		parent::make();

	}

	public function formClass()
	{
		return  '\\_m\\webpage\\view\\element\\form\\Form';
	}
}
