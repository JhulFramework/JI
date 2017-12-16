<?php namespace _m\webpage\view\type\element;

interface _Interface
{

	public function add( $name, $content );

	public function addLink( $name, $content ); //->addURL($url);

	public function compileContent();

	//@access child
	public function child( $name );

	public function key();

	public function setParent( $element );
}
