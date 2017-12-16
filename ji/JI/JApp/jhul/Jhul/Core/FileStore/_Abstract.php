<?php namespace Jhul\Core\FileStore;

class _Abstract
{

	private function initDirectory( $directory  )
	{
		if ( !file_exists( $directory ) )
		{
			mkdir( $directory , 0755, true);
		}
	}

	public function has( $name )
	{
		$file = $this->path().'/'.$name.'.'.$extension;

		return is_file($file) ;
	}

	public function get( $filename  )
	{
		$file = $this->path().'/'.$filename;

		if( is_file($file) )
		{
			return $file ;
		}
	}

	public function getPath( $filename  )
	{
		return $this->path().'/'.$filename; ;
	}

	public function saveFile( $content, $name  )
	{
		$file = $this->path().'/'.$name;

		$directory = dirname( $file );

		$this->initDirectory( $directory );

		$this->_saveFile( $content, $file );
	}


	private function _saveFile( $content, $file )
	{

		$fp = fopen( $file , 'w' );

		if( flock($fp, LOCK_EX | LOCK_NB ) )
		{
			// truncate file
			ftruncate($fp, 0);
			fwrite($fp, $content);

			// flush output before releasing the lock
			fflush($fp);
			flock($fp, LOCK_UN);    // release the lock
		}
		else
		{
			//TODO show server busy page
			echo 'FileManager : Server Is Busy, Please Try Again later';
			exit ;
			throw new \Exception( 'Error Writing To File "'.$file.'" ' , 1);
		}

		fclose($fp);

		return TRUE ;
	}
}
