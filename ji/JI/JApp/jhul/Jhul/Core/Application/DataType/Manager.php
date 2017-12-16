<?php namespace Jhul\Core\Application\DataType;

class Manager
{

	use \Jhul\Core\_AccessKey;

	private static $_I;

	protected $_loaded = [];

	protected $_map = [];

	public function __construct()
	{
		$this->_map =
		[
			'string'	=> __NAMESPACE__.'\\Types\\String\\Attribute',
			'email'	=> __NAMESPACE__.'\\Types\\Email\\Attribute',
			'alpha'	=> __NAMESPACE__.'\\Types\\Alpha\\Attribute',
			'alnum'	=> __NAMESPACE__.'\\Types\\Alnum\\Attribute',
			'namekey'	=> __NAMESPACE__.'\\Types\\NameKey\\Attribute',
			'pdn'		=> __NAMESPACE__.'\\Types\\PDN\\Attribute',
			'image' 	=> __NAMESPACE__.'\\Types\\Image\\Attribute',
		];
	}

	public function map()
	{
		return $this->_map;
	}

	public function register( $name, $class = NULL, $overwrite = FALSE )
	{
		//mass
		if( is_array($name))
		{
			foreach ($name as $n => $c)
			{
				$this->register( $n, $c, $overwrite );
			}
			return;
		}

		if( (isset($this->_map[$name]) &&  $class != $this->_map[$name] ) && !$overwrite )
		{
			throw new \Exception( 'Data Type name "'.$name.'" for class "'.$class.'" is already used by "'.$this->_map[$name].'"' , 1);
		}

		if( empty($class) )
		{
			throw new \Exception( 'Data Type "'.$name.'"\'s class must not be empty ' );
		}

		if( !class_exists($class) )
		{
			throw new \Exception( 'Data Type "'.$name.'" class "'.$class.'" does not exists' );
		}

		$this->_map[ $name ] = $class;

	}

	protected $_ifKeep = TRUE;

	public function setIfKeep( $bool )
	{
		$this->_ifKeep = TRUE === $bool;

		return $this;
	}

	public function get( $name, $params = [] )
	{
		if( !empty($params) )
		{
			return $this->_get( $name )->addParams($params);
		}

		return $this->_get( $name );
	}


	protected function _get( $name )
	{
		if( strpos( $name, '?' ) )
		{
			$m = explode( '?', $name );

			$name = $m[0];
			$modify = $m[1];

			return $this->_get( $name )->addParams( $modify );
		}

		if( $this->hasDataType( $name ) )
		{
			$class = $this->map()[$name];

			$dataType = new $class;

			return $dataType->addParams( $this->J()->fx()->loadConfigFile( $this->J()->fx()->dirPath( $class ).'/_params', FALSE ) );
		}

		throw new \Exception( 'Data Type "'.$name.'" Not Found', 1 );
	}

	public function hasDataType($type)
	{
		return isset( $this->_map[$type] );
	}

}
