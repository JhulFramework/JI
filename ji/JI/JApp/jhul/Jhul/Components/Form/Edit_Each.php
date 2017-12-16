<?php namespace Jhul\Components\Form;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+----------------------------------------------------------------------------------------------------------------------
| @created Saturda

| Only a single field can be edited
| @Updated : 2017-Sep-17
+--------------------------------------------------------------------------------------------------------------------*/

abstract class Edit_Each extends EditDBEntity
{

	protected $_currentField;
	protected $_saveHandler ;
	protected $_isFile = FALSE;


	public function __construct( )
	{
		parent::__construct();

		if( isset($_GET['edit']) )
		{
			if( $this->mField()->has( $_GET['edit'] ) )
			{
				$this->_currentField = $_GET['edit'];
			}
			elseif( $this->mFile()->has( $_GET['edit'] ) )
			{
				$this->_currentField = $_GET['edit'];
				$this->_isFile = TRUE;

			}

		}

		if( !empty( $this->_currentField ) )
		{
			$this->_saveHandler =  $this->saveHandlers()[ $this->_currentField ];
		}
	}

	public function currentField()
	{
		return $this->_currentField ;
	}

	public function isFile()
	{
		return TRUE == $this->_isFile ;
	}

	public function ifFieldSelected()
	{
		return NULL != $this->currentField() ;
	}

	public function isSubmitted()
	{
		if( $this->ifFieldSelected() )
		{
			if( $this->isFile() )
			{
				if( isset( $_FILES[ $this->currentField() ] ) )
				{

					$name = $this->currentField();

					$this->$name = $this->getApp()
					->mDataType( $this->mFile()->get( $this->currentField(), 'definition' ) )
					->make( $_FILES[ $this->currentField() ] );

					return TRUE ;
				}
			}

			elseif( isset( $_POST[ $this->name() ][ $this->currentField() ] ) )
			{

				$name = $this->currentField();

				$this->$name = $this->getApp()
				->mDataType( $this->mField()->get( $this->currentField(), 'definition' ) )
				->make( $_POST[ $this->name() ][ $this->currentField() ] );

				return TRUE ;
			}
		}

		return FALSE ;
	}


	public function save()
	{
		$method = $this->_saveHandler;

		$name = $this->currentField();

		$this->$method( $name );
	}
}
