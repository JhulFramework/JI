<?php namespace Jhul\Core\Application\Module;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017-Sep-07
|
| @Responsibilities
| -Install module on first run
|
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Installer
{

	public static function I()
	{
		return new static() ;
	}


	public function J()
	{
		return \Jhul::I();
	}

	public function __construct()
	{
		$this->dbSchema = $this->j()->fx()->loadConfigFile
		(
			$this->j()->fx()->dirPath( get_called_class() ).'/_db_schema'
		) ;
	}

	public function db()
	{
		return  \Jhul::I()->cx('dbm')->getDB();
	}

	public function app()
	{
		return \Jhul::I()->app();
	}

	abstract public function dbTablePrefix();
	abstract public function install();

	public function _install()
	{
		$this->installDB();
		$this->install();
	}

	public function installDB()
	{
		
		foreach ( $this->dbSchema as $t => $p )
		{
			$this->db()->createTable( $this->dbTablePrefix().'_'.$t, $p['fields'], $p['meta']  );
		}

	}

}
