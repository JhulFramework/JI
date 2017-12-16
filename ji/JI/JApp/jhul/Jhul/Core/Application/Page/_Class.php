<?php namespace Jhul\Core\Application\Page;

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	public $statusCode = 200;

	public $title = '' ;

	protected $ifEnableIndexing = FALSE ;

	protected $_directory;

	public static function I() { return new static(); }

	public abstract function makeWebPage();

	//GUI Builder
	public function guib()
	{
		return $this->app()->m('webpage') ;
	}

	public function directory()
	{
		if( empty($this->_directory) )
		{
			$this->_directory = $this->J()->fx()->dirPath(get_called_class());
		}

		return $this->_directory;
	}

	public final function make( $params = [] )
	{
		if( !$this->context()->isAccessible() ) return ;

		if( $this->app()->user()->request()->mode() == 'json'  )
		{
			$this->makeJSON( $params );
		}

		if( $this->app()->user()->request()->mode() == 'webpage'  )
		{
			$this->makeWebPage( $params );

			if( !empty( $this->title ) )
			{
				$this->app()->response()->page()->setTitle( $this->title );
			}

			if( $this->ifEnableIndexing )
			{
				$this->app()->response()->page()->enableIndexing();
			}
		}

		$this->app()->response()->setStatusCode( $this->statusCode );
	}

	public function removeLayout( $key )
	{
		$this->app()->response()->page()->layout()->remove($key);
	}

	public function cookText( $text )
	{
		$this->app()->response()->page()->addContent($text);
	}

	public function cookLocalFile( $view, $params = [] )
	{
		$this->app()->renderFile( $this->directory().'/'. $view, $params );
	}

	public function cookFile( $layout, $params = [] )
	{
		$this->app()->renderFile( $layout, $params );
	}

	public function cook( $name, $params = [] )
	{
		$this->module()->cook( $name, $params );
	}

	public function hasQuery( $key, $value )
	{
		return isset($_GET[$key]) && $value == $_GET[$key] ;
	}

	public function disableWrapper()
	{
		$this->app()->response()->page()->setUseLayout(FALSE);
	}
}
