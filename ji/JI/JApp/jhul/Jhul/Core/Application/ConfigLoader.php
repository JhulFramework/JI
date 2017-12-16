<?php namespace Jhul\Core\Application;


class ConfigLoader
{
	use \Jhul\Core\_AccessKey;

	public function load( &$obj )
	{
	 	$this->_configure( $obj );

		$this->mapResources( $obj->path() );
	}


	protected function _configure( &$obj )
	{
		$obj->config()->add
		(
			$this->loadConfigFile( $obj->path().'/_config/_main', FALSE )
		);

		$this->app()->mDataType()->register
		(
			$this->loadConfigFile( $obj->path().'/_config/_datatypes', FALSE )
		);

		//$obj->elementMap = $this->loadConfigFile( $obj->path().'/config/elements/_map', FALSE );
	}


	public function mapResources( $path )
	{
		$this->app()->lipi()->register( $this->loadConfigFile( $path.'/res/i18n/_map', FALSE  ) );
	}

	protected function loadConfigFile( $file, $required = TRUE )
	{
		return $this->J()->fx()->loadConfigFile( $file, $required );
	}

	public function loadContextMap( $domainPath )
	{
		return $this->loadConfigFile( $domainPath.'/_config/_contexts', FALSE );
	}

}
