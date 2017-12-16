<?php namespace JI;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017NOV19
|
| @Updated : 2017DEC15
+---------------------------------------------------------------------------------------------------------------------*/


class Installer
{
	use \JI\_AccessKey;

	private $_key;

	private $_config;


	//form source directory path
	private $_fieldMap;

	public function __construct( $key, $path )
	{
		$this->_key = $key;
		$this->_config = $this->j()->fx()->readConfigFile( $path.'/_config', FALSE );
		$this->_fieldMap = $this->readFieldMap( $path );
	}

	public function key()
	{
		return $this->_key ;
	}

	public function j()
	{
		return \Jhul::I() ;
	}

	public function module()
	{
		return \Jhul::I()->app()->m('pai') ;
	}

	public function appContext()
	{
		return \Jhul::I()->app()->context('pai@setup') ;
	}


	public function run()
	{
		$this->appContext()->form()->mfield()->setMap( $this->_fieldMap );

		$this->appContext()->setFormConfig( $this->key(),  $this->_config );

		if( $this->appContext()->isSkipped() )
		{
			$this->finish();
		}
		elseif( $this->appContext()->form()->isSubmitted() && $this->appContext()->form()->validate() )
		{
			foreach ( $this->appContext()->form()->submittedData() as $field => $value )
			{
				$this->setConfig( $field, $value );
			}

			$this->finish();
		}

		$this->appContext()->run();

		return \Jhul::I()->app()->response()->send();
	}

	private function finish()
	{
		\JI::I()->setConfiguredStatus( $this->key() , TRUE );
		\JI::I()->commit();
		header( 'Location: '.trim( $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '/') );
		exit();
	}

	public function setConfig( $key, $value )
	{
		\JI::I()->setConfig( $this->key().'.'.$key, $value );

		return $this ;
	}

	public function readFieldMap( $path )
	{
		$file =  $path.'/_fields.php';

		if( !is_file($file))
		{
			throw new \Exception( 'Field Map File "'.$file.'" Not Found!' , 1);
		}

		$fields = $this->j()->fx()->readConfigFile( $path.'/_fields', FALSE );

		if(empty($fields))
		{
			throw new \Exception( 'No Fields Defined for form "'.$this->key().'" in file "'.$file.'"  ' , 1);
		}

		return $fields ;
	}
}
