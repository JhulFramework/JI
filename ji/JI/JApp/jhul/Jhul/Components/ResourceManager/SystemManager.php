<?php namespace Jhul\Components\ResourceManager;


class SystemManager extends _manager
{

	public function registerName()
	{
		return '_system_resource_map';
	}

	public function map()
	{
		if( NULL === $this->_map )
		{
			$file = $this->mapFile();

			if( !file_exists($file) )
			{
				$this->writer()->write( $this->fileName(), json_encode( [] )  );
			}

			$this->_map = json_decode(file_get_contents( $file ));
		}

		return $this->_map
	}

	public function _create(  )
	{
		$this->writer()
	}
}
