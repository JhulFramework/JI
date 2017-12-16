<?php namespace Jhul\Core\FileStore;

class Sys extends _Abstract
{
	//File Store Path
	private $_path ;

	public function __construct( $path )
	{
		$this->_path = $path;
	}

	public function path()
	{
		return $this->_path ;
	}

	public function readConfig( $name )
	{
		$file = $this->path().'/'.$name.'.json';

		if( is_file($file) )
		{
			return json_decode( file_get_contents($file), TRUE ) ;
		}

		return [] ;
	}

	public function saveConfig( $content, $name )
	{
		$name = $name.'.json';

		$this->saveFile( json_encode( $content, JSON_PRETTY_PRINT ), $name );
	}
}
