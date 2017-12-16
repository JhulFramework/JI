<?php namespace Jhul\Components\Database\DAO;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created : 2016-August-13
+--------------------------------------------------------------------------------------------------------------------*/

interface _Interface
{
	

	//Check if this entity has field
	public function has( $field );

	//Check if this entity has field
	public function hasAccessToColumn( $field );

	public function hasWriteAccess();

}
