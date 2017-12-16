<?php namespace Jhul\Components\ResourceManager;


class Writer
{

	// public function aswrite( $filename, $content )
	// {
	// 	$path = pathinfo( $filename );
	//
	// 	$this->touchDirectory( $path['dirname'] );
	//
	//
	// 	$file = fopen( $filename , 'w+b' );
	// 	fwrite( $file, $content );
	// 	fclose( $file );
	// }

	public function write( $filename, $content )
	{
		if( !file_exists($filename) )
		{
			$this->create( $filename, $content );

		}
		else
		{
			$this->update( $filename, $content );
		}
	}

	public function update( $filename, $content )
	{
		file_put_contents( $filename, $content, LOCK_EX );
	}

	public function create( $filename, $content )
	{
		$path = pathinfo( $filename );

		$this->touchDirectory( $path['dirname'] );

		 file_put_contents( $filename, $content, LOCK_EX );
	}


	//creates, if upload directory not exists
	public function touchDirectory( $dir )
	{

		if( is_dir( $dir ) || @mkdir( $dir , 0775, true) )
		{
			return TRUE;
		}

		throw new \Exception('Directory "'.$dir.'" Not Exists/Not Creatable ');
	}


	public function delete( $filename )
	{
		$this->adapter()->delete( $filename );
	}


}
