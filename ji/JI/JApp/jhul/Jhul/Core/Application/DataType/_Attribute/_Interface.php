<?php namespace Jhul\Core\Application\DataType\_Attribute;

interface _Interface
{
	//returns value object if value is valid
	public function filter( $value );

	//return Error Code Manager
	public function mErrorCode();

	//returns value entity object
	public function make( $value );

	public function type();

	public function addParams( $params );

	//@param : $rule = string example 'length:1-10:size=10:20'
	public function decodeDefinition( $defintion );
}
