<?php namespace Jhul\Components\Database\Manager;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
|
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class extends _Base
{
	public static function dao( $context  )
	{
		$dataClass = static::I()->getDAOClass( $context );

		return $dataClass::I();
	}

	//item dispenser
	public static function D( $context )
	{
		if( empty($context) )
		{
			throw new \Exception("Error Processing Request", 1);

		}


		$dataClass = static::I()->getDAOClass( $context );

		if( !class_exists( $dataClass ) )
		{
			throw new \Exception( $dataClass , 1);
		}

		return $dataClass::D();
	}


	//only create and return datamodel using data array, but does not saves it to database
	public function create(  $context, $params = []  )
	{
		return $this->initilizeFields( static::dao( $context ), $params );
	}

	//create data model from data array, saves it database and return datamodel
	public function createAndCommit( $context, $params = [] )
	{
		return $this->commit( $this->create( $context, $params ) );
	}
}
