<?php namespace Jhul\Components\Database\Manager;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
|
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Base
{

	use \Jhul\Core\_AccessKey;

	protected $_fields = [];

	// Data Access Object Class map
	protected $_dao_map =
	[
		'null' => __NAMESPACE__.'\\Data\\_NULL',
	];

	// save record to database
	// @return modified datamodel
	// @param $DAO can be data entity
	private function insert( $DAO )
	{
		$DAO = $this->_callBefore( 'insert', $DAO );

		$this->getDB()->insert( $DAO );

		$key = $this->getDB()->pdo()->lastInsertId();

		//setting persistent data as old data
		$DAO->_oData()->_set( $DAO->_pData()->_get() );

		//setting modified data as persistent data
		$DAO->_pData()->_set( $DAO->_mData()->_get() );

		if( $DAO->_mData()->has( $DAO->keyName() ) )
		{
			$key = $DAO->_mData()->read( $DAO->keyName() );
		}

		$DAO->_pData()->_set( $DAO->keyName(), $key );

		return $this->_callAfter( 'insert', $DAO );
	}

	public function _callBefore( $method, $DAO )
	{
		$method = 'before'.$method;

		return method_exists( $this, $method ) ? $this->$method( $DAO ) : $DAO ;
	}

	public function _callAfter( $method, $DAO )
	{
		$method = 'after'.$method;

		return method_exists( $this, $method ) ? $this->$method( $DAO ) : $DAO ;
	}



	public function commit( $DAO, $forced = FALSE )
	{
		if( !$DAO->isModified() && !$forced ) return;

		$DAO = $this->_callBefore( 'commit', $DAO );

		$DAO = $DAO->isPersistent() ? $this->update($DAO) : $this->insert( $DAO ) ;

		return $this->_callAfter( 'commit', $DAO );
	}

	public function DAOMap() { return $this->_dao_map; }

	public function defaultValues(){ return []; }

	//compress or preprocess data befor storing in database
	public function deflateValue( $value, $field )
	{
		if( isset($this->valueDeflaters()[ $field ] )  )
		{
			$deflater = $this->valueDeflaters()[ $field ];

			return $this->$deflater( $value, $field );
		}

		return $value;
	}



	public function delete( $DAO  )
	{
		$this->_callBefore( 'delete', $DAO );

		$DAO->getDB()->_delete( $DAO );

		$this->_callAfter( 'delete', $DAO );
	}

	public function getDAOClass( $context )
	{
		if( is_object($context) )
		{
			throw new \Exception("Error Processing Request", 1);
		}

		if( isset( $this->_dao_map[$context] ) )
		{
			$class = $this->_dao_map[$context] ;

			return is_array( $class ) ? $class['class'] : $class ;
		}

		throw new \Exception( 'Context "'.$context.'" Not Defined In "'.get_called_class().'" ' );
	}


	public function getQueryColumns( $DAO )
	{
		if( isset( $this->_dao_map[$DAO->context()]['select'] ) )
		{
			$fields = $this->_dao_map[$DAO->context()]['select'];

			if( is_array($fields)) return $fields;

			if( strpos( $fields, ':' ) ) return explode( ':', $fields );

			if( $fields == '*' ) return '*';

			return [$fields];
		}

		throw new \Exception( 'No fields selected for context "'.$DAO->context().'" in "'.get_called_class().'" ' , 1);
	}


	public function getDB(){ return \Jhul::I()->cx('dbm')->getDB(); }

	public function htmlEncode( $string, $maxLength = 0 )
	{
		return $this->j()->cx('html')->encode( $string, $maxLength ) ;
	}

	public static function I()
	{
		return \Jhul::I()->cx('dbm')->getStore( get_called_class() );
	}

	//expands data to readable
	public function inflateValue( $value, $field )
	{
		if( isset($this->valueInflaters()[$field] )  )
		{
			$inflater = $this->valueInflaters()[$field];

			return $this->$inflater( $value, $field );
		}

		return $value;
	}

	// - initilize fields of newly created Item
	// - Check if all fields are initilized
	public function initilizeFields( $DAO, $params )
	{
		foreach ( $this->defaultValues() as $key => $value)
		{
			$DAO->write( $key, $value );
		}

		foreach ( $params  as $key => $value)
		{
			$DAO->write($key, $value);
		}

		return $DAO;
	}

	//register DAO Class
	public function register( $context, $params )
	{
		$this->_dao_map[$context] = $params;
		return $this;
	}

	//Updates Already existing record
	private function update( $DAO )
	{
		$DAO = $this->_callBefore( 'update', $DAO );

		$this->getDB()->update( $DAO );

		$DAO->_oData()->_set( $DAO->_pData()->_get() );

		$DAO->_pData()->_set( $DAO->_mData()->_get() );

		return $this->_callAfter( 'update', $DAO );
	}

	public function useNULLDataModel(){ return FALSE; }

	public function valueDeflaters(){ return []; }

	public function valueInflaters(){ return []; }

}
