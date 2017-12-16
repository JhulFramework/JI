<?php namespace Jhul\Components\ResourceManager;

class UI
{
	use \Jhul\Core\_AccessKey;

	protected $_file_manager;

	// Delius+Unicase
	public function linkGoogleFont( $name )
	{
		$this->app()->response()->page()->style()->link( 'font:'.$name,  'https://fonts.googleapis.com/css?family='.$name, FALSE );
	}


	public function url( $name = NULL )
	{
		if( NULL == $name )
		{
			return $this->app()->url().'/'.$this->app()->pubCacheDir();
		}

		return $this->url().'/'.$name;
	}

	public function destination()
	{
		return $this->app()->publicRoot().'/'. $this->app()->pubCacheDir();
	}

	public function mFile()
	{
		if( empty($this->_file_manager) )
		{
			$this->_file_manager = new FileManager( $this->destination() );
		}

		return $this->_file_manager;
	}

	public function mResource()
	{
		return $this->app()->mResource();
	}

	public function invalidateCache()
	{
		$this->MFile()->deleteCache();
	}

	public function addCssFile( $name, $source_file )
	{
		$source_file = $source_file.'.css';

		$name = 'style_'.$name;

		if( !$this->mFile()->has( $name ) )
		{
			$this->mFile()->create( $name, $source_file );
		}

		$this->app()->response()->page()->style()->link( $name, $this->url( $this->mFile()->rPath( $name ) ) );
	}


	public function addJSFile( $name, $source_file )
	{
		$source_file = $source_file.'.js';
		$name = 'script_'.$name;

		if( !$this->mFile()->has( $name ) )
		{
			$this->mFile()->create( $name, $source_file );
		}

		$this->app()->response()->page()->script()->link( $name, $this->url( $this->mFile()->rPath( $name ) ) );
	}
}
