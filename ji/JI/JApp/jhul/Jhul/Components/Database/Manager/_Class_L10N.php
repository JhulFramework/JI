<?php namespace Jhul\Components\Database\Manager;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
| Language based item store
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class_L10N extends _Base
{

	// prototype object creation
	public static function DAO( $context, $l10n  )
	{
		$dataClass = static::I()->getDAOClass( $context );

		return new $dataClass( $l10n );
	}

	//item dispenser
	// prototype object creation
	public static function D( $context, $l10n )
	{
		$item = static::get( $context, $l10n );

		return $item->getDatabase()->dispenser( $item );
	}

	//when creatind item we have to make sure all field must be intilized
	public function create(  $context, $params = [], $l10n  )
	{
		return $this->initilizeFields( static::DAO( $context, $l10n ), $params );
	}

	public function createAndCommit( $context, $params = [], $l10n )
	{
		return $this->commit( $this->create( $context, $params, $l10n ) );
	}
}
