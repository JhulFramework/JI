<?php namespace Jhul\Core\FileStore;

class Pub extends _Abstract
{
	//File Store Path
	private $_cacheDirectory ;
	private $_publicRoot ;
	private $_baseURL ;
	private $_path;

	public function __construct( $cacheDirectory, $publicRoot, $baseURL )
	{
		$this->_cacheDirectory = $cacheDirectory;
		$this->_publicRoot = $publicRoot;
		$this->_baseURL = $baseURL;
		$this->_path = $this->_publicRoot.'/'.$this->_cacheDirectory;
	}

	public function cacheDirectory()
	{
		return $this->_cacheDirectory ;
	}

	public function path()
	{
		return $this->_path ;
	}

	public function _url()
	{
		return $this->_baseURL.'/'.$this->_cacheDirectory ;
	}

	/*
	| returns public resource file url
	*/
	public function url( $filename )
	{
		return $this->_url().'/'.$filename ;
	}
}
