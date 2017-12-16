<?php namespace _m\webpage;

class Module extends \Jhul\Core\Application\Module\_Class
{
	protected $_loaded = [];

	protected $_form_builder;

	private $_coreBuilder;

	protected $_views =
	[
		//'edit_text' 		=> __NAMESPACE__.'\\components\\form\\Builder',
		//'form'			=> __NAMESPACE__.'\\components\\form\\Builder',
		//'textarea_form'		=> __NAMESPACE__.'\\components\\form\\Builder',
		'simple_index' 		=> __NAMESPACE__.'\\components\\index\\Builder',
		//'page_navigation' 	=> __NAMESPACE__.'\\components\\navigation\\Builder',
	];

	private $_themes =
	[
		'dark' => __NAMESPACE__.'\\view\\theme\\dark\\Theme',
	];

	private $_theme;

	public function theme()
	{
		if( empty($this->_theme) )
		{
			$class = $this->_themes['dark'];

			$this->_theme = new $class;
		}

		return $this->_theme;
	}

	public function renderFile( $file, $params = [] )
	{
		return $this->makeView( $file, $params );
	}

	public function makeView( $file, $params = [] )
	{
		$content = file_get_contents( $file);

		if( !empty($params) )
		{
			foreach ( $params as $key => $value )
			{
				$params[ '|{{'.$key.'}}|' ] = $value;
				unset($params[$key]);
			}

			$content = preg_replace(array_keys($params), array_values($params), $content );
		}

		return $content;
	}

	protected $_components = [];

	private function _make( $component, $params = [] )
	{
		if( isset($this->_components[$component]) )
		{
			$class = $this->_components[$component];

			return new $class(  $this->j()->fx()->dirpath( $class ) , $params );
		}

		throw new \Exception( 'webpage component "'.$component.'" not found ' , 1);

	}

	//show html coomponent
	public function show( $component, $params = [] )
	{
		$component = $this->make( $component, $params );

		$data = [] ;

		foreach ( $component->resources() as $res )
		{
			$data[$res] = $component->$res;
		}

		return $this->j()->cx('html')->showArray( $data );
	}


	public function getComponentPath( $class )
	{
		return $this->J()->fx()->dirPath( $class );
	}

	public function loadStyle( $path, $name )
	{
		return $this->minifyStyle(file_get_contents( $path .'/'.$name.'.css'  ));
	}

	public function loadScript( $path, $name )
	{
		return file_get_contents( $path .'/'.$name.'.js'  );
	}

	public function loadView( $template, $layout )
	{
		return $this->renderFile( $template.'.php', $layout->views() );
	}

	public function adminURL()
	{
		return $this->getApp()->url().'/admin/webpage';
	}

	public function formBuilder()
	{
		if( empty($this->_form_builder) )
		{
			$this->_form_builder = new Form\Builder();
		}

		return $this->_form_builder;
	}

	//return the view builder component
	public function get( $component )
	{
		if( isset( $this->_loaded[$component] ) )
		{
			return $this->_loaded[$component];
		}

		if( !isset( $this->_views[$component] ) )
		{
			throw new \Exception( 'Components "'.$component.'" not found ' , 1);
		}

		$component = $this->_views[$component];

		$this->_loaded[$component] = new $component;

		return $this->_loaded[$component] ;
	}

	public function createView( $layout, $dirNamespace )
	{
		$layout->compile();

		if( $layout->hasScript() )
		{
			$this->app()->mPubCache()->writeFile( $dirNamespace.'/script' , $layout->script(), 'js' );
		}

		if( $layout->hasStyle() )
		{
			$this->app()->mPubCache()->writeFile( $dirNamespace.'/style' , $layout->style(), 'css' );
		}

		return $this->app()->mSysCache()->writeFile( $dirNamespace.'/body' , $layout->content() );
	}

	public function minifyStyle( $style )
	{
		$style = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $style);

		$style = str_replace(': ', ':', $style);

		// Important use double quote
		return str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $style);
	}


	private $_builder;

	public function builder()
	{
		if( empty($this->_builder) )
		{
			$this->_builder = new components\Builder;
		}

		return $this->_builder;
	}

}
