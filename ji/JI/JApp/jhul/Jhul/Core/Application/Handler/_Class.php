<?php namespace Jhul\Core\Application\Handler;

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	//override it to implement conditional handling
	public function canHandleNextNode() { return FALSE; }

	protected function breadcrumb(){ return []; }

	public function isAccessible(){ return TRUE; }



	public function isVirtual(){ return FALSE; }

	public function cook( $name, $params = [] )
	{
		$this->module()->cook( $name, $params );
	}


	public function handle()
	{
		throw new \Exception( 'Please define method "handle()" in class "'.get_called_class().'"' , 1);
	}

	public function hasQuery( $key, $value )
	{
		return isset($_GET[$key]) && $value == $_GET[$key] ;
	}

	public function nextPathSegment( $data_type_filter = NULL )
	{
		if( $data_type_filter )
		{
			return $this->app()->mDataType($data_type_filter)->make( $this->mPath()->next() )->value();
		}

		return $this->mPath()->next();
	}

	public function mPath()
	{
		return $this->app()->user()->request()->route()->navigator();
	}

	public function route()
	{
		return $this->app()->user()->request()->route();
	}

	public function nextHandler(){}

	//@Structure: [ 'nextNodeNameType' => 'handler' ]
	// types [ string, alnum . . . ]
	public function nextNodeNameTypes(){ return []; }

	//@Structure: [ 'next_path_match' => 'handler' ]
	public function nextNodeNames(){ return []; }

	public function makePage( $page = NULL  )
	{
		return NULL != $page ? $this->module()->makePage( $page ) : $this->makeLocalPage() ;
	}

	public function makeLocalPage( $page = 'Page' )
	{
		$class = $this->J()->fx()->getFromNamespace( $page , get_called_class() );

		return $class::I()->make();
	}

	//switch handler
	public function switchTo(){}

	public function switchPage(){}

	public function switchToLocalPage(){}

}
