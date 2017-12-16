<?php namespace Jhul\Core;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Updated : 2017-Aug-30
+---------------------------------------------------------------------------------------------------------------------*/
trait _AccessKey
{

	private $_addonKey ;

	private $_moduleKey ;

	private $_context ;

	private $_domainType ;

	public function J()
	{
		return \Jhul::I();
	}

	public function app()
	{
		return $this->J()->app() ;
	}


	public function context()
	{
		if( empty($this->_context) )
		{
			$this->_context = $this->module()->getContextByNamespace( get_called_class() );
		}

		return $this->_context ;
	}


	public function module()
	{
		if( NULL == $this->_moduleKey )
		{
			$paths = explode('\\', trim( get_called_class(), '\\' ) );

			$k = array_search( '_modules', $paths ); //deprecated

			if( FALSE === $k )
			{
				$k = $paths[1] ;
			}

			if( FALSE === $k )
			{
				throw new \Exception( 'This class "'.get_called_class().'" is not a part of any module' , 1);
			}

			$this->_moduleKey = strtolower( $paths[ $k + 1 ] );
		}

		return $this->app()->m( $this->_moduleKey );
	}

	public function addOn()
	{
		if( NULL == $this->_addonKey )
		{
			$namespace =  trim( get_called_class(), '\\' );

			$identifier = '_m\\'.$this->module()->key().'\\addon\\';

			if( 0 === strpos( $namespace, $identifier ) )
			{
				$slug = explode( '\\', str_replace($identifier, '', $namespace ) );
				$this->_addonKey = $slug[0];
			}

			if( empty($this->_addonKey) )
			{
				throw new \Exception( 'This class "'.get_called_class().'" is not a part of any Addon' , 1);
			}

		}

		return $this->module()->addon($this->_addonKey);
	}

	public function domain()
	{
		if( empty($this->_domainType) )
		{
			if( 0 === strpos(get_called_class(), '_m\\' ) )
			{
				$this->_domainType = 'module';

				if( 0 === strpos(get_called_class(), '_m\\'.$this->module()->key().'\\addon\\' ) )
				{
					$this->_domainType = 'addon';
				}
			}
		}

		if( $this->_domainType == 'module' )
		{
			return $this->module() ;
		}

		if( $this->_domainType == 'addon' )
		{
			return $this->addon() ;
		}

		throw new \Exception( 'This Object Has No Domain' , 1);

	}

}
