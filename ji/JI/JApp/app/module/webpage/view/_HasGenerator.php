<?php namespace _m\webpage\view;

trait _HasGenerator
{
	public $_dirNamespace;

	public function name()
	{
		return $this->context()->name();
	}

	public function dirNamespace()
	{
		if( empty($this->_dirNamespace) )
		{
			$this->_dirNamespace = $this->domain()->dirNamespace().'/'.$this->context()->name().'/_view_'.$this->name();
		}

		return $this->_dirNamespace ;
	}

	public function touchViewFile()
	{
		$file = $this->viewFile();

		if( !file_exists( $file ) )
		{
			$this->generate();
		}

		if( !file_exists( $file ) )
		{
			throw new \Exception( 'Failed To create view file "'.$file.'" ' , 1);
		}
	}


	//relative filename
	public function _viewFileName( $withExtension = TRUE )
	{
		if( $withExtension )
		{
			return $this->dirNamespace().'/body.php' ;
		}

		return $this->dirNamespace().'/body' ;

	}

	//relative filename
	public function _styleFileName( $withExtension = TRUE )
	{
		if( $withExtension )
		{
			return $this->dirNamespace().'/style.css' ;
		}

		return $this->dirNamespace().'/style' ;
	}

	//relative filename
	public function _scriptFileName( $withExtension = TRUE )
	{
		if( $withExtension )
		{
			return $this->dirNamespace().'/script.js' ;
		}

		return $this->dirNamespace().'/script' ;

	}

	public function viewFile( $withExtension = TRUE )
	{
		return $this->J()->mSysFileStore()->getPath( $this->_viewFileName($withExtension) );
	}

	public function styleFile()
	{
		return $this->J()->mPubFileStore()->getPath( $this->_styleFileName() );
	}

	public function scriptFile()
	{
		return $this->J()->mPubFileStore()->getPath( $this->_scriptFileName() );
	}


	public function styleURL( $extension = TRUE )
	{
		return $this->j()->mPubFileStore()->url( $this->_styleFileName( $extension ) );
	}

	public function scriptURL( $ext = TRUE )
	{
		return $this->j()->mPubFileStore()->url( $this->_scriptFileName( $ext) );
	}

	public function linkScript()
	{
		$this->app()->response()->page()->script()->link( $this->name(), $this->scriptURL(FALSE) );
	}

	public function linkStyle()
	{
		$this->app()->response()->page()->style()->link( $this->name(), $this->styleURL(FALSE) );
	}

	public function cookView( $params = [] )
	{
		$this->touchViewFile();
		$params['page'] = $this;
		$this->app()->renderFile( $this->viewFile( FALSE ), $params );
	}

	public function form( )
	{
		$this->context()->form();
	// 	if( empty($this->_form) )
	// 	{
	// 		$class = $this->j()->fx()->rChop( get_called_class() ).'\\Form';
	//
	// 		$this->_form = new $class;
	// 	}
	//
	// 	return $this->_form ;
	}

	public function generate()
	{
		$class = $this->j()->fx()->rChop( get_called_class() ).'\\_view\\Generator';
		$class::I()->generate( $this );
	}
}
