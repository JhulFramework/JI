<?php namespace _m\webpage\view;


abstract class _Generator
{
	use \Jhul\Core\_AccessKey;

	public static function I() { return new static() ; }

	public function builder(){ return $this->app()->m('webpage') ; }

	public function show( $str )
	{
		return htmlspecialchars( $str, ENT_QUOTES, 'utf-8' );
	}

	// Must return view
	abstract public function createView();

	public function generate()
	{
		$this->_generate( $this->createView() ) ;
	}

	private function _generate( $layout )
	{
		$layout->compile();

		if( $layout->hasScript() )
		{
			$this->j()->mPubFileStore()->saveFile( $layout->script() , $this->page()->_scriptFileName() );
		}

		if( $layout->hasStyle() )
		{
			$this->j()->mPubFileStore()->saveFile( $layout->style() , $this->page()->_styleFileName() );
		}

		$this->J()->mSysFileStore()->saveFile( $layout->content(), $this->page()->_viewFileName() );
	}

	public function page()
	{
		return $this->context()->page() ;
	}
}
