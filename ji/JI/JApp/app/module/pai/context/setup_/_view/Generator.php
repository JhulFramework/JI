<?php namespace _m\pai\context\setup_\_view;

class Generator extends \_m\webpage\view\_Generator
{
	public function createView()
	{
		$layout = new Layout( $this->context()->page()->name() );

		$form = ( new Form )
		->setTitle( $this->context()->formConfig('title')  )
		->setDescription( $this->context()->formConfig('description')  );

		$layout->setFragment( 'form', $form );

		return $layout ;
	}
}
