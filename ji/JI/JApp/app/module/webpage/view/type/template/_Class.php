<?php namespace _m\webpage\view\type\template;

abstract class _Class extends \_m\webpage\view\_Class implements _Interface
{

	use \Jhul\Core\_AccessKey;

	public $_fragmentStyles = [];

	public $_fragmentScripts = [];

	//strings
	protected $_fragments = [];

	//view file map
	private $_viewFileMap = [] ;

	//view file map
	private $_styleFileMap = [] ;

	private $_prepend = [];

	private $_styles = [];

	private $_scripts = [];

	public function fragments()
	{
		return $this->_fragments ;
	}

	public static function loadFileContents( $file, $extension = 'php' )
	{
		return file_get_contents( $file.'.'.$extension );
	}

	public function compileContent()
	{
		$content = '';

		foreach ( $this->_prepend as $view )
		{
			$content .= is_object($view) ? $view->content() : static::loadFileContents($view);
		}

		foreach ( $this->useTemplates() as $view )
		{
			$content .= static::loadFileContents( $this->resDirPath().'/'.$view );
		}

		$content =  static::injectFragment( $content, $this->fragments() );

		return $content ;
	}

	public static function injectFragment( $content, $fragments = [] )
	{
		if( !empty($fragments) )
		{
			foreach ( $fragments as $key => $value )
			{
				$fragments[ '|{{'.$key.'}}|' ] = $value;
				unset($fragments[$key]);
			}

			$content = preg_replace(array_keys($fragments), array_values($fragments), $content );
		}

		return $content;
	}


	public function compileStyle()
	{
		$style = '';

		foreach ( $this->useStyles() as $s )
		{
			$style .= static::loadFileContents( $this->resDirPath().'/'.$s, 'css' );
		}

		//loading fragments styles
		$style .= implode( ' ', $this->_styles );

		return $style ;
	}

	public function compileScript()
	{
		$script = '';

		foreach ( $this->useScripts() as $s )
		{
			$script .= static::loadFileContents( $this->resDirPath().'/'.$s, 'js' );
		}

		$script .= implode( ' ', $this->_scripts );

		return $script ;

	}

	//@param template file path without extension (.php)
	public function prepend( $key, $view )
	{
		if(is_object($view))
		{
			$view->compile();
			$this->_styles[$key] = $view->style();
			$this->_scripts[$key] = $view->script();
		}

		$this->_prepend = [ $key => $view ] + $this->_prepend;
		return $this;
	}


	public function addScript( $key, $value )
	{
		$this->_scripts[$key] = $value;
		return $this;
	}

	public function addStyle( $key, $value )
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


	public function hasStyle()
	{
		return !empty($this->_style) ;
	}

	public function hasScript()
	{
		return !empty($this->_script) ;
	}

	public function setFragment( $key, $view )
	{
		if( is_object($view) )
		{
			$view->compile();
			$this->_styles[$view->name()] = $view->style();
			$this->_scripts[$view->name()] = $view->script();
			$view = $view->content();
		}

		$this->_fragments[$key] = $view;

		return $this ;
	}

	// public function cacheName()
	// {
	// 	return $this->module()->dirNamespace().'/views/'.$this->name();
	// }

	// final public function name()
	// {
	// 	return $this->context()->page()->name();
	// }
}
