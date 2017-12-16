<?php namespace Jhul\Core\Application\Response\WebPage;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created Mon 09 Nov 2015 01:55:10 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

class Template
{
	use \Jhul\Core\_AccessKey;

	protected $_current_path ;

	protected $_current_view_name;

	protected $_res = [];

	protected $_value_seperator = '|';

	protected $_rendered_files = [];

	public function uix( $sub = NULL )
	{
		if( !empty( $sub ) ) return $this->J()->cx('uix')->com( $sub );

		return $this->J()->cx('uix');
	}

	public function __construct()
	{
		$this->register( 'error404', __DIR__.'/resources/error404' );
	}


	public function renderView( $file, $params = [] )
	{
		$time = (string) (round( microtime(true) - JHUL_START_TIME,6) );

		$this->_rendered_files[ $time ] = $file;


		ob_start();

		extract($params, EXTR_OVERWRITE);


		require($file);

		return ob_get_clean();
	}

	public function breadCrumbs()
	{
		return $this->getPage()->mBreadCrumb()->create();
	}


	public function dirPath( $file )
	{
		return mb_substr( $file, 0, strrpos( $file, '/' ) );
	}

	public function get( $name )
	{
		if( isset($this->_res[$name]) )
		{
			return $this->_res[$name];
		}


		throw new \Exception('Template "'.$name.'" Not Mapped');
	}

	public function mScript()
	{
		return $this->app()->response()->page()->script();
	}

	public function mStyle()
	{
		return $this->app()->response()->page()->style();
	}

	public function getPage()
	{
		return $this->app()->response()->page();
	}

	public function html()
	{
		return $this->J()->cx('html');
	}

	public function ui()
	{
		return $this->J()->cx('resource_manager')->ui();
	}


	public function load( $name, $params = [] )
	{

		$view = $this->app()->mapper()->get( $name );

		if( is_array($view) )
		{
			$this->_current_path = $this->dirPath( $view['template'] );

			if( isset($view['style']) )
			{
				$this->loadCSS( $view['style'] );
			}

			//if view is consist of child view(s)
			if( !empty($view['view']) )
			{
				$cView = $view['view'];


				//if it consistsof multiple child views
				if( strpos( $cView, $this->_value_seperator ) )
				{
					$cNames = explode(  $this->_value_seperator , $cView );


					$p = $params;

					foreach ($cNames as $c)
					{
						$params['view'][$c] = $this->load( $c, $p );
					}
				}

				//if it consist of only one child view
				else
				{
					$params['view'][$cView] =  $this->load( $cView, $params );
				}

			}

			$this->_current_view_name = $name;
			return  $this->buffer( $view['template'], $params ) ;
		}


		$this->_current_view_name = $name;
		return $this->buffer( $view.'.php', $params ) ;
	}


	public function loadCss( $css )
	{
		if( strpos( $css, $this->_value_seperator ) )
		{
			$cArray = explode( $this->_value_seperator, $css );

			foreach ($cArray as $c)
			{
				$this->loadCss( $c );
			}
		}
		else
		{

			if( !$this->embedCss( $css ) )
			{
				throw new \Exception( 'Css "'.$css.'" Not Found In Path '.$this->_current_path , 1);
			}
		}
	}


	public function buffer( $file, $params = [] )
	{

		if( is_file($file) )
		{
			$this->_current_path = $this->dirPath( $file );

			$output = $this->renderView( $file , $params );

			$this->_current_path = NULL;

			return $output;
		}

		if( NULL != $this->_current_path )
		{
			$cFile = $this->_current_path.'/'.$file.'.php';

			if( is_file( $cFile) ) return $this->renderView( $cFile , $params );

		}


		throw new \Exception( 'View File "'.$file.'" May Not exists' );

	}

	public function embedStyleSheet( $css_file_name = NULL )
	{
		if( NULL == $css_file_name )
		{
			$list =  explode( '.', $this->_current_view_name);

			$css_file_name = $list[1];
		}

		$file = $this->_current_path.'/'.$css_file_name.'.css';

		$this->mStyle()->embed( $this->renderView( $file ), $css_file_name );
	}

	//embed  raw javascript
	public function embedScript( $script, $identity_key )
	{
		$this->mScript()->embed( $script, $identity_key );
	}

	//embed javascript from file
	public function embedScriptFile( $script_file_name = NULL )
	{
		if( NULL == $script_file_name )
		{
			$list =  explode( '.', $this->_current_view_name);

			$script_file_name = $list[1];
		}

		$file = $this->_current_path.'/'.$script_file_name.'.js';

		$this->mScript()->embed( $this->renderView( $file ), $script_file_name );
	}


	public function map()
	{
		return $this->_res;
	}

	public function register( $name, $view = NULL, $definition_file = NULL )
	{

		if( is_array($name) )
		{
			foreach ( $name as $n => $v)
			{
				$this->register( $n, $v, $definition_file );
			}

			return;
		}

		if( is_array( $view ) )
		{
			$file = $view['f'].'.php';

			if( !empty($definition_file) && 0 !== strpos($file, '/') )
			{
				$file = dirname($definition_file).'/'.$file;
			}

			if( !is_file($file) )
			{
				throw new \Exception( 'Template file "'.$file.'" does not exists defined in file '.$definition_file.'.php' , 1);
			}


			$view['f'] = $file;

		}
		else
		{
			$view .= '.php';

			if( !empty($definition_file) && 0 !== strpos($view, '/') )
			{
				$view = dirname($definition_file).'/'.$view;
			}

			if( !is_file( $view ) )
			{
				throw new \Exception( 'Template File "'.$view.'" does not exists defined in file '.$definition_file.'.php', 1);
			}
		}

		$this->_res[$name] = $view;
	}

	public function encode( $text )
	{
		return htmlspecialchars( $text, ENT_QUOTES, 'utf-8' );
	}

	public function renderedFiles()
	{
		return $this->_rendered_files;
	}

	public function res(){ return $this->_res; }

	public function showRenderedFiles()
	{
	 	$html = '';

		foreach ( $this->renderedFiles()  as $key => $value)
		{
			$html .= '<br/> time : '.$key.' | rendering view : '.$value;
		}

		return $html;
	}

	public function translate( $key )
	{
		return $this->app()->lipi()->t( $key );
	}
}
