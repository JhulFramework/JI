<?php namespace Jhul\Componenets\FileManager;


class PublicManager extends _Manager
{
	//website url
	protected $_base_url;

	public function __construct( $path, $map, $base_url )
	{
		parent::__construct( $path, $map );
		$this->_base_url = $base_url;
	}

	public function getLink( $name, $returnOnFail )
	{
		return $this->baseURL().'/'.$this->get( $name, $returnOnFail )
	}

	public function baseURL(){ return $this->_base_url; }

	public function map()
	{
		if( NULL === $this->_map )
		{
			$this->_map = $this->mResource()->mSystem()->getOrCreate( 'public_resource_map', [] );
		}

		return $this->_map;
	}

	public function registerName()
	{
		return '_public_resource_map';
	}

	public function getOrCreate( $name,  $source_file )
	{
		if( $this->has($name) ) return $this->getLink($name);

		$this->create( $name, $source_file );

		$this->getLink($name);
	}

	public function createImage( $name,  $source )
	{
		$this->touchDirectory( $this->destination().'/images' );

		$file_name = $this->generateFileName( 'images/'.$name, pathinfo($source, PATHINFO_EXTENSION ) );

		$this->set( $name, $source )

		return $name;
	}

}
