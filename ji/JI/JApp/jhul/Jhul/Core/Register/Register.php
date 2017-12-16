<?php namespace Jhul\Core\Register;

/* @Author: Manish Dhruw
+=======================================================================================================================
| @Created : 2017NOV19
+---------------------------------------------------------------------------------------------------------------------*/


class Register
{
	use \Jhul\Core\_AccessKey;

	private $_data = [];
	private $_key ;

	public function __construct( $key, $data )
	{
		$this->_key = $key;
		$this->_data = $data;
	}

	public function data()
	{
		return $this->_data ;
	}

	public function key()
	{
		return $this->_key ;
	}

	public function get($key, $required = TRUE)
	{
		if( strpos( $key, '.' ) )
		{
			$keys = explode('.', $key);

			$p = $this->_data;

			foreach ($keys as $k )
			{

				if( !empty($k) &&  is_array($p) && isset($p[$k]) )
				{
					if( is_array($p) && isset($p[$k]) )
					{
						$p = $p[$k] ;
					}
				}

				elseif (!$required)
				{
					return [] ;
				}
				else
				{
					throw new \Exception( 'Configuration "'.$key.'" Not Set!' , 1);
				}
			}

			return $p ;
		}
		else
		{
			if( isset($this->_data[$key]) )
			{
				return $this->_data[$key] ;
			}
			if (!$required)
			{
				return [] ;
			}
		}



		throw new \Exception( 'Configuration "'.$key.'" Not Set!' , 1);
	}

	public function set( $key, $value)
	{
		if( strpos($key, '.') )
		{
			$keys = explode( '.', $key );

			$p = &$this->_data;

			foreach ($keys as $k)
			{
				if( !empty($k) )
				{
					if(!isset($p[$k]))
					{
						$p[$k] = [];
					}

					$p = &$p[$k];
				}
				else
				{
					throw new \Exception( 'Failed To Set Key "'.$key.'" ' , 1);
				}
			}

			$p = $value;

			unset($p);
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this ;
	}

	public function commit()
	{
		$this->j()->mReg()->save($this->key());
	}
}
