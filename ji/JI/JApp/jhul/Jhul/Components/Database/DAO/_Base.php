<?php namespace Jhul\Components\Database\DAO;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created : Saturday 15 February 2014 10:35:28 AM IST
| @Updated : [ 2015Jan03, 2015April09, 2016July07, 2016-August[06,13], 2016Sep04 , 2017Jun25 ]
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Base
{

	use \Jhul\Core\_AccessKey;

	protected $_accessibleColumns = [];

	protected $_dataBags = [];

	protected $_executedQuery;

	protected $_inflated = [];

	protected $_queryColumns = [];

	abstract public function keyName() ;

	public function managerClass()
	{
		return 'Jhul\\Components\\Database\\Manager\\Manager' ;
	}

	abstract public function tableName() ;

	public function getDB() { return $this->J()->cx('dbm')->getDB(); }

	public function getDataBag( $name )
	{
		if( !isset( $this->_dataBags[ $name ]  ) )
		{
			$this->_dataBags[$name] = new DataBag( $this );
		}

		return $this->_dataBags[$name];
	}

	public function has( $field ){ return $this->_pData()->has($field); }

	public function hasWriteAccess() { return FALSE; }

	public function ifEmpty( $field, $silent = TRUE )
	{
		return empty( $this->read($field, $silent) );
	}

	//if its nul Data model
	public function isNull(){ return FALSE ;}

	public function key()
	{
		return $this->_pData()->read( $this->keyName() );
	}


	//Persitent Data (committed to the database)
	public function _pData(){ return $this->getDataBag('persistent'); }

	// @Param $data : from database
	// @Param $sql : used sql to load this data from database
	public function _populate( array $data, $sql )
	{
		$this->_pData()->_set( $data );

		$this->_executedQuery = $sql ;

		return $this;
	}

	public function read( $field, $silent = FALSE )
	{
		if( isset( $this->_prepared[$field] ) ) return $this->_prepared[$field];

		// pass to custom datareader
		if( isset( $this->readHandlers()[ $field ] ) && !$byPass )
		{
			$readHandler = $this->readHandlers()[ $field ];

			$this->_prepared[$field] = $this->$readHandler( $this->_read( $field, $silent ) );
		}

		$this->_prepared[$field] = $this->store()->inflateValue( $this->_read($field), $field );

		return $this->_prepared[$field];
	}

	//returns encoded value
	public function _read( $field, $silent = FALSE )
	{
		if( $this->hasAccessToColumn( $field )  )
		{
			return $this->_pData()->read( $field );
		}

		if( !$silent )
		{
			throw new \Exception( 'ERROR_NO_READ_ACCES to field "'. get_called_class().'::'.$field.'" ' , 1);
		}

		return NULL;
	}

	protected function readHandlers(){ return []; }

	public function store()
	{
		return $this->manager();
	}

	public function manager()
	{
		return $this->J()->cx('dbm')->getStore( $this->managerClass() );
	}

	public function accessFields()
	{
		return $this->context()->daoFields( get_called_class() ) ;
	}

	public function hasAccessToColumn($key)
	{
		if( '*' == $this->accessFields() ) return TRUE;

		return in_array( $key, $this->accessibleColumns() );
	}

	public function executedQuery(){ return $this->_executedQuery; }

	public function write( $key, $value )
	{
		throw new \Exception( 'This DB Enitity "'.get_called_class().'" has no write access' , 1);
	}

	public function _write( $key, $value )
	{
		throw new \Exception( 'This DB Enitity "'.get_called_class().'" has no write access' , 1);
	}
}
