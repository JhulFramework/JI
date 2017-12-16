<?php namespace _m\main;

class Module extends \Jhul\Core\Application\Module\_Class
{
	public function tableMeta( $name )
	{
		return context\sys\dao\TableMeta::findByName( $name ) ;
	}

	public function createTableMeta( $tableName )
	{
		$tm = $this->tableMeta($tableName);

		if( NULL == $tm  )
		{

			$count = $this->j()->cx('dbm')->getDB()->_countTableRows($tableName) ;
			$tm = context\sys\dao\TableMeta::create( $tableName, $count ) ;
		}


		return $tm;
	}

	public function updateTableMeta( $tableName )
	{
		$tm = $this->tableMeta($tableName);

		$count = $this->j()->cx('dbm')->getDB()->_countTableRows($tableName) ;

		if( NULL == $tm  )
		{
			$tm = context\sys\dao\TableMeta::create( $tableName, $count ) ;
		}
		else
		{
			$tm->write('row_count', $count )->commit();
		}

		return $tm;
	}
}
