<?php namespace _m\webpage\view\type\template;

abstract class _Class extends \_m\webpage\view\_Class implements _Interface
{
	public $_styles = [];

	public $_scripts = [];

	//strings
	protected $_fragments = [];

	public function compileContent()
	{
		$this->_content = '';

		foreach ( $this->_prepend as $view )
		{
			$this->_content .= is_object($view) ? $view->compileContent() : static::loadFileContents($view);
		}

		foreach ( $this->useTemplates() as $view )
		{
			$this->_content .= static::loadFileContents( $this->resDirPath().'/'.$view );
		}

		$this->_content =  static::injectFragment( $this->_content, $this->subViews() );

		return $this->_content ;
	}

	public static function injectSubViews( $content, $subviews = [] )
	{

		if( !empty($subviews) )
		{
			foreach ( $subviews as $key => $value )
			{
				$subviews[ '|{{'.$key.'}}|' ] = $value;
				unset($subviews[$key]);
			}

			$content = preg_replace(array_keys($subviews), array_values($subviews), $content );
		}

		return $content;
	}


	public function compileStyle()
	{
		$this->_style = '';

		foreach ( $this->useStyles() as $style )
		{
			$this->_style .= static::loadFileContents( $this->resDirPath().'/'.$style, 'css' );
		}

		$this->_style .= implode( ' ', $this->_styles );

		return $this->_style ;
	}

	public function compileScript()
	{
		$this->_script = '';

		foreach ( $this->useStyles() as $script )
		{
			$this->_script .= static::loadFileContents( $this->resDirPath().'/'.$script, 'css' );
		}

		$this->_script .= implode( ' ', $this->_scripts );

		return $this->_style ;

	}

	// public function compile()
	// {
	// 	foreach ( $this->useStyles() as $name )
	// 	{
	// 		$this->_styles[$name] =  $this->builder()->loadStyle( $this->resDirPath(), $name );
	// 	}
	//
	// 	foreach ( $this->useScripts() as $name )
	// 	{
	// 		$this->_scripts[$name] =  $this->builder()->loadScript( $this->resDirPath(), $name );
	// 	}
	//
	// 	foreach ( $this->_viewFileMap() as $key => $template)
	// 	{
	// 		$this->_views[$key] = $this->builder()->loadView( $template, $this );
	// 	}
	//
	// }

	public function prependContent( $key, $viewfile )
	{

	}


	//@param template file path without extension (.php)

	public function prepend( $key, $view )
	{
		$this->_prepend = [ $key => $view ] + $this->_prepend;
		return $this;
	}


	public function setScript( $key, $value )
	{
		$this->_scripts[$key] = $value;
		return $this;
	}

	public function setStyle( $key, $value )
	{
		$this->_styles[$key] = $value;
		return $this;
	}

	public function useScripts()
	{
		return [] ;
	}

	public function useStyles()
	{
		return [] ;
	}

	public function useTemplates()
	{
		return [] ;
	}

	public function builder()
	{
		return $this->app()->m('webpage');
	}

	public function resDirPath()
	{
		throw new \Exception( 'Please Define Method "'.get_called_class().'::resDirPath()" ' , 1);
	}

	public function content()
	{
		return $this->_wrapContent(implode( ' ', $this->_views )) ;
	}

	public function hasStyle()
	{
		return !empty($this->_style) ;
	}

	public function hasScript()
	{
		return !empty($this->_script) ;
	}

	public function addSubView( $key, $view )
	{
		if( is_object($view) )
		{
			$view->compile();
			$this->_styles[$view->name()] = $view->style();
			$this->_scripts[$view->name()] = $view->script();
			$view = $view->content();
		}

		$this->_subViews[$key] = $view;

		return $this ;
	}

	public function views( $key = NULL )
	{
		if( empty($key) ) return $this->_views;

		if( isset( $this->_views[$key] ) ) return $this->_views[$key];
	}

	public function cacheName()
	{
		return $this->module()->dirNamespace().'/views/'.$this->name();
	}

}
