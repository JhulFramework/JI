<?php namespace _m\webpage\view\element\form;

abstract class Form extends \_m\webpage\view\_Class
{

	use \Jhul\Core\_AccessKey;
	use \_m\webpage\view\element\_HasAttributes;

	private $_name ;

	private $_title ;

	//child view objects
	private $_fieldViewObjects;


	private $_fieldsSerialized = [];

	private $_viewTypeMap =
	[
		'editText' 		=> __NAMESPACE__.'\\field\\EditText',
		'editTextBig' 	=> __NAMESPACE__.'\\field\\EditTextBig',
		'token' 		=> __NAMESPACE__.'\\field\\Token',
		'selectOne' 	=> __NAMESPACE__.'\\field\\SelectOne',
		'button' 		=> '\\_m\\webpage\\view\\element\\Button',
	];

	public function dm()
	{
		return $this->context()->form() ;
	}

	public function __construct()
	{
		$this->setAttribute( 'method', 'post' );
		$this->setAttribute( 'action', '' );
		$this->_viewTypeMap = array_merge( $this->_viewTypeMap, $this->useViewTypeMap() );
		$this->createFields();
	}

	public function viewTypeMap()
	{
		return $this->_viewTypeMap ;
	}

	// public function fields()
	// {
	// 	return [] ;
	// }

	public function mField()
	{
		return $this->dm()->mField();
	}

	public function name()
	{
		return $this->dm()->name() ;
	}

	private $_autoAddButton = TRUE;

	public function setAutoAddButton( $bool )
	{
		$this->_autoAddButton = $bool;
		return $this ;
	}

	public function serializeFieldViewObjects()
	{
		if( !isset($this->_fieldsSerialized['button']) && $this->_autoAddButton )
		{
			$this->addButton();
		}

		return implode( ' ', $this->_fieldsSerialized ) ;
	}

	private function createFields()
	{

		foreach ( $this->mField()->keys() as $field )
		{
			if( !isset($this->_fieldViewObjects[$field]) && $this->mField()->has($field, 'view_type') )
			{
				$viewType = $this->mField()->get($field, 'view_type');

				if( strrpos( $viewType, '\\' ) )
				{
					$this->addField( $field, new $viewType() );
				}
				else
				{
					$this->addFieldByKey( $field, $viewType );
				}
			}
		}
	}


	public function make()
	{
		$this->createFields();

		$content = '<div class="fields">'.$this->serializeFieldViewObjects().'</div>' ;

		if( NULL != $this->description() )
		{
			$content = '<div class="description">'.$this->description().'</div>'.$content ;
		}

		if( NULL != $this->title() )
		{
			$content = '<div class="title">'.$this->title().'</div>'.$content ;
		}

		return '<form '.$this->serializeAttributes().' >'.$content.'</form>';
	}

	public function compileStyle(){}
	public function compileScript(){}

	public function compileContent()
	{
		return '<div class="'.$this->wrapperClass().'" >'.$this->make().'</div>' ;
	}

	public function title()
	{
		return $this->_title ;
	}

	public function enableFileUpload()
	{
		return $this->setAttribute( 'enctype', 'multipart/form-data' );
	}

	public function setTitle( $title )
	{
		$this->_title = $title ;
		return $this ;
	}

	public function description()
	{
		return '' ;
	}

	public function wrapperClass()
	{
		return 'formWrapper'  ;
	}

	private $_loadParams = [ 'label', 'id' ];

	private $_fields = [] ;

	/*
	| add fields and immediatly serializes it
	| @param $key  = field key
	| @param $object  = field view object
	*/
	public function addField( $key, $view )
	{
		$view->set('name', $key);
		$view->set('id', $key);

		if( $view->attribute('type') == 'file' )
		{
			$this->enableFileUpload();
		}
		else
		{
			//do not set form name on files
			$view->set( 'form_name', $this->name() );
		}

		foreach ($this->_loadParams as $param)
		{
			if( $this->mField()->has( $key, $param ) )
			{
				$view->set( $param, $this->mField()->get($key, $param) );
			}
		}

		$view->compile();

		//$this->_fieldViewObjects[ $key ] = $view;
		$this->_fieldsSerialized[ $key ] = $view->content();

		return $this;
	}

	public function addToken( $key = 'token' )
	{
		$this->addFieldByKey( $key, 'token' );
		return $this;
	}

	public function addButton( $content = 'Save' )
	{
		$class = $this->viewTypeMap()['button'];

		$b = new $class( 'button' );

		$b->set('content', $content);

		$this->addField( 'button', $b );
		return  $this;
	}

	public function addFieldByKey( $key, $type )
	{
		if( isset($this->viewTypeMap()[$type]) )
		{
			$class = $this->viewTypeMap()[$type];

			$this->addField( $key, new $class($key) );
		}
		else
		{
			throw new \Exception( 'field type "'.$type.'" Not defined for "'.$key.'" ! use addField( \''.$key.'\' , new YourFieldClass() ) or add it in []useViewTypeMap() ' , 1);
		}
	}

	public function useViewTypeMap() { return [] ; }

	//public function viewMap() { return [] ; }
}
