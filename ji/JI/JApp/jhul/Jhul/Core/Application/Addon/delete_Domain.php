<?php namespace Jhul\Core\Application\Addon;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017Oct17
+---------------------------------------------------------------------------------------------------------------------*/

trait _Domain
{
	use \Jhul\Core\Application\Module\_Domain;

	private $_addonKey ;

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
		return $this->addon() ;
	}
}
