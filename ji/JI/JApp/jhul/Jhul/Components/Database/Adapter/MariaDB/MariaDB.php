<?php namespace Jhul\Components\Database\Adapter\MariaDB;


class MariaDB
{
	protected $_pdo;

	//Multiple stores of same class having different aspects can exists
	protected $_stores;

	public function addStore( $context, $table ) { $this->_stores[$context] = $table; }

	public function __construct( $pdo )
	{
		$this->_pdo = $pdo;
	}

	public function _countTableRows( $table_name)
	{
		$rows = $this->executeStatement( $this->makeStatement( 'SELECT COUNT(*) FROM `'.$table_name.'`' ) )->fetch();

		if( NULL != $rows )
		{
			return  $rows[0] ;
		}

		throw new \Exception( 'Table "'.$table_name.'" not found' , 1);

	}


	public function _delete( $item )
	{
		$statement = $this->executeStatement
		(
			$this->makeStatement( 'delete'  )->setTable( $item->tableName() )->where( $item->keyName(),  $item->key() )
		);

		$statement = NULL ;
	}

	public function hasTable( $name )
	{
		return isset($this->tables()[$name]);
	}

	public function createTable( $name, $structure, $meta = '', $overwrite = FALSE )
	{
		if( !$this->hasTable($name) || $overwrite )
		{
			$sql = 'CREATE TABLE `'.$name.'` ('.$structure.') '.$meta.' ;';

			$this->executeStatementString($sql);

			return TRUE;
		}

	}

	public function dispenser( $prototype )
	{
		return new Dispenser( $prototype );
	}

	public function executeStatementString( $statement )
	{
		$statement = $this->executeStatement
		(
			$this->makeStatement( $statement  )
		);

		$statement = NULL ;
	}

	public function executeStatement( $statement )
	{
		try
		{
			$preparedStatement = $this->pdo()->prepare( $statement->make() );
			$preparedStatement->execute( $statement->values() ) ;
			return $preparedStatement;
		}
		catch ( \Exception $e)
		{
			throw new \Exception( $e->getMessage().$statement->show() );
		}
	}

	public function getTableColumns( $table_name )
	{
		$schema = $this->tableSchema($table_name);

		$columns = [];

		foreach ($schema as $key => $value)
		{
			$columns[$key] = $key;
		}

		return $columns ;
	}

	//Tbale is common but statement cannot be shared
	//TODO use a better way to preven statement sharing
	public function getStore( $context_table )
	{
		if( isset( $this->_stores[ $context_table ] ) )
		{
			return $this->_stores[ $context_table ];
		}

		throw new \Exception( 'Table Mode "'.$context_table.'" Not Created ' );
	}

	public function hasStore( $context_table ){ return isset( $this->_stores[$context_table] ); }

	public function insert( $item )
	{
		if( !is_object($item) )
		{
			throw new \Exception("Error Processing Request", 1);

		}

		$statement = $this->executeStatement
		(
			$this->makeStatement( 'insert'  )->setTable( $item->tableName() )->setData( $item->_mData()->_get() )
		);

		$statement = NULL ;
	}

	public function _loadTableSchema( $name )
	{
		return  $this->makeStatement( 'show_columns' )->setTable($name)->cookData( $this->pdo() );
	}

	public function makeStatement( $type = 'custom' ){ return Statement\Statement::I()->make( $type ); }

	public function name()
	{
		if( NULL == $this->_name )
		{
			$pos = strrpos( $this->dsn, '='  ) ;

			$this->_name = substr( $this->dsn, $pos + 1 );
		}

		return $this->_name ;
	}

	public function pdo(){ return $this->_pdo; }

	protected $_tables = [];

	public function tableSchema( $name )
	{
		if( !empty( $name ) )
		{
			if( array_key_exists( $name, $this->tables() ) )
			{
				if( empty( $this->_tables[$name] ) )
				{
					$this->_tables[$name] = $this->_loadTableSchema( $name );
				}

				return $this->_tables[$name] ;
			}

			return [];
		}
	}

	// Return All tables of this database
	public function tables()
	{
		if( empty( $this->_tables ) )
		{
			//TODO CUSTOM statement
			$tables = $this->executeStatement( $this->makeStatement( 'SHOW TABLES' ) )->fetchAll();

			foreach ($tables as $value)
			{
				$this->_tables[ $value[0] ] = [];
			}
		}
		return $this->_tables;
	}


	public function update( $item )
	{
		$statement = $this->executeStatement
		(
			$this->makeStatement( 'update'  )->setTable( $item->tableName() )
			->setData( $item->_mData()->_get() )->where( $item->keyName(),  $item->key() )
		);

		$statement = NULL ;
	}

}
