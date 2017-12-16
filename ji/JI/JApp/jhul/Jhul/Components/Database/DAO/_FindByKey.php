<?php namespace Jhul\Components\Database\DAO;

trait _FindByKey
{
	public static function find( $identity_key )
	{
		return static::D()->byKey( $identity_key )->fetch();
	}
}
