<?php namespace _m\webpage\view;

/* @Author : Manish Dhruw
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 10NOV2017
+=====================================================================================================================*/

interface _Interface
{

	/*
	| return everything as HTML embeddable including style content and script
	*/
	public function asHTML();

	/*
	| compiles everything ( content, style, script)
	+------------------------------------------------*/
	public function compile();

	/*
	| Compile style on call and return as string
	+------------------------------------------------*/
	public function compileContent();

	/*
	| Compile style on call and return as string
	+------------------------------------------------*/
	public function compileStyle();

	/*
	| Compile javascript on call and return as string
	*/
	public function compileScript();

	/*
	| @returns HTML without style content and script
	*/
	public function content();


	/*
	| return name of view element/layout
	*/
	public function name();

	//returns css
	public function style();

	//returns script
	public function script();


	/*
	| return compiled style as html embedable
	| example <style>css</style>
	| return null on empty
	+-------------------------------------------------*/
	public function styleAsHTML();

	/*
	| return compiled script as html embedable
	| example <script>script</script>
	| return null on empty
	*/
	public function scriptAsHTML();

}
