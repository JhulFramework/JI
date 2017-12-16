<?php namespace Jhul\Core\Application\Response\WebPage;

/* @AUTHOR Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 09-Nov-2015 10:37:26 AM IST
| Style Manager
+---------------------------------------------------------------------------------------------------------------------*/

class Style
{

	use \Jhul\Core\_AccessKey;

	protected $_embedded = [];

	protected $_res = [];

	// public accessible linked css files
	private $_linked = [];

	public $publicCSS = [];

	//Root dir of linkable css
	public $publicDirectory ;

	//Registers linkable css file, public accessible
	public function registerLink( $name, $path = NULL)
	{
		if( is_array($name) )
		{
			foreach ($name as $key => $value)
			{
				$this->registerLink( $key, $value );
			}

			return ;
		}

		$this->publicCSS[$name] = $path;
	}

	public function __toString()
	{
		return $this->toString();
	}

	public function toString()
	{
		return $this->links().$this->embedded();
	}

	public function publicCssURL( $name )
	{
		if( isset( $this->publicCSS[$name] ) )
		{
			return $this->_link( $this->app()->url().'/'. $this->app()->publicResDir().'/'.$this->publicCSS[$name].'.css' );
		}

		throw new \Exception('Public CSS '.$name.' not Mapped ', 1);
	}

	public function link( $name, $link = NULL, $addExtension = TRUE )
	{
		if( !empty($link) )
		{
			$this->_linked[$name] = $this->_link( $link, $addExtension );
			return ;
		}

		if( !isset( $this->_linked[$name] ) )
		{
			$this->_linked[$name] = $this->publicCssURL( $name );
		}
	}

	private function _link( $url,  $addExtension = TRUE )
	{
		$url = $addExtension ? $url.'.css' : $url;

		return '<link href="'.$url.'" rel="stylesheet" type="text/css" />' ;
	}

	public function links()
	{
		return implode( '', $this->_linked );
	}

	public function register( $id, $path = NULL, $defined_file = NULL )
	{
		if( is_array($id) )
		{
			foreach ($id as $i => $p)
			{
				$this->register($i, $p, $defined_file);
			}

			return;
		}

		if( !isset( $this->_res[$id] ) )
		{
			$file = $path.'.css';

			if( !is_file($file) )
			{
				throw new \Exception( 'CSS resource File "'.$file.'" does not exists defined in file '.$defined_file , 1);
			}

			$this->_res[$id] = $file;
		}

		if( $this->_res[$id] != ($path.'.css') )
		{

			throw new \Exception( 'Css file already registered('.$this->_res[$id].') by identity key "'.$id.'" ' , 1);
		}

	}

	//Can embed both file and code
	public function embed( $css, $id = NULL, $overWrite = FALSE )
	{

		if( is_string($css) && strpos( $css, '{' ) )
		{
			return $this->embedCode( $css, $id, $overWrite );
		}

		return $this->embedFile( $css );
	}

	//embeds code
	public function embedCode( $code, $id =  NULL, $overWrite = FALSE )
	{
		if( NULL == $id )
		{
			$id = substr( $code, 0 , 8 );
		}

		if( !isset( $this->_embedded[$id] ) || $overWrite )
		{
			$this->_embedded[$id] = $code ;
			return TRUE;
		}

		return FALSE;
	}


	//Embed CSS Mapped Files
	public function embedFile( $name )
	{
		if( is_array($name) )
		{
			foreach ($name as $value)
			{
				if( FALSE == $this->embedFile($value) )
				{
					return FALSE;
				}
			}

			return TRUE;
		}

		if(  isset( $this->_res[$name] )   && !isset( $this->_embedded[$name] ) )
		{
			$this->_embedded[$name] = $this->buffer( $this->_res[$name] );

			return TRUE;
		}

		return FALSE;
	}


	public function res()
	{
		return $this->_res;
	}

	public function saveToFile( )
	{
		$map = $this->app()->path().'/resources/css/tmp/map.json';

		$css = $this->app()->path().'/resources/css/tmp/compiled.css';
	}


	public function embedded()
	{
		return '<style type="text/css" >'.implode(' ', $this->_embedded ).'</style>';
	}

	protected function buffer( $file )
	{
		ob_start();

		require($file);

		return ob_get_clean();
	}

	public function map()
	{
		return $this->_res;
	}
}
