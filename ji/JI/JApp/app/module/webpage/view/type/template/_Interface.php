<?php namespace _m\webpage\view\type\template;

/* @Author : Manish Dhruw
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 10NOV2017
+=====================================================================================================================*/

interface _Interface
{

	/*
	| @return : directory path containing all view resources( styles, scripts, templates)
	*/
	public function resDirPath();


	/*
	| @returns array of names of view files which need to be loaded from resource directory
	| @exampe : [ 'body', 'main' ];
	*/
	public function useTemplates();


	/*
	| @returns array of names of stylessheets files which need to be loaded from resource directory
	| @exampe : [ 'style', 'normalize' ];
	*/
	public function useStyles();

	/*
	| @returns array of names of javascript files which need to be loaded from resource directory
	| @exampe : [ 'jquery', 'main' ];
	*/
	public function useScripts();

	//adds sub view (which get replaced by there place holder)
	public function setFragment( $key, $view );

	/*
	| add view to the top
	| @param : can be view object or view file
	*/
	public function prepend( $key, $view );
}
