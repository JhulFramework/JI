<?php namespace Jhul\Core\Application\Module;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017Oct19
+---------------------------------------------------------------------------------------------------------------------*/

trait _Domain
{
	private $_moduleKey ;

	private $_context ;

	public function context()
	{
		if( empty($this->_context) )
		{
			$this->_context = $this->module()->getContextByNamespace( get_called_class() );
		}

		return $this->_context ;
	}

	public function J()
	{
		return \Jhul::I();
	}

	public function app()
	{
		return $this->J()->app() ;
	}

	//@deprecated
	public function getApp()
	{
		return $this->J()->app() ;
	}

	public function module()
	{
		if( NULL == $this->_moduleKey )
		{
			$paths = explode('\\', trim( get_called_class(), '\\' ) );

			$k = array_search( '_modules', $paths ); //deprecated

			if( FALSE === $k )
			{
				$k = array_search( '_m', $paths );
			}

			if( FALSE === $k )
			{
				throw new \Exception( 'This class "'.get_called_class().'" is not a part of any module' , 1);
			}

			$this->_moduleKey = strtolower( $paths[ $k + 1 ] );
		}

		return $this->getApp()->m( $this->_moduleKey );
	}

	public function domain()
	{
		return $this->module() ;
	}
}
