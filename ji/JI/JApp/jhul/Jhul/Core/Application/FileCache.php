<?php namespace Jhul\Core\Application;

class FileCache
{
	//filce cache path
	private $_path ;

	public function __construct( $path )
	{
		$this->_path = $path;
	}

	public function path()
	{
		return $this->_path ;
	}

	private function initDirectory( $directory  )
	{
		if ( !file_exists( $directory ) )
		{
			mkdir( $directory , 0755, true);
		}
	}

	public function has( $name, $fileFormat = 'php'  )
	{
		$file = $this->path().'/'.$name.'.'.$fileFormat;

		return  is_file($file) ;
	}

	public function get( $name, $fileFormat = 'php'  )
	{
		$file = $this->path().'/'.$name.'.'.$fileFormat;

		if( is_file($file) )
		{
			return $file ;
		}
	}

	public function getResource( $name  )
	{
		return $this->path().'/'.$name;
	}

	public function filePath( $name, $fileFormat = 'php'  )
	{
		return $this->path().'/'.$name.'.'.$fileFormat; ;
	}

	public function writeFile( $name, $content, $fileFormat = 'php'  )
	{
		$layout = $this->path().'/'.$name ;

		$file = $this->path().'/'.$name.'.'.$fileFormat;

		$directory = dirname( $file );

		$this->initDirectory( $directory );

		file_put_contents( $file, $content );

		return $layout ;
	}

	public function writeConfig( $name, $content  )
	{
		$file = $this->path().'/'.$name.'.json';

		$directory = dirname( $file );

		$this->initDirectory( $directory );

		file_put_contents( $file, json_encode($content) );

		return $file ;
	}

	public function readConfig( $name )
	{
		$file = $this->path().'/'.$name.'.json';

		if ( file_exists( $file ) )
		{
			return json_decode( file_get_contents( $file ), TRUE );
		}

		return [];
	}
}
