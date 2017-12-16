<?php namespace Jhul\Core\Application\DataType\Types\Image;

Class Definition
{
	public static $limit_keys =
	[
		's'	=> 'size',
		'w'	=> 'width',
		'h'	=> 'height',
	];

	public static function setLimit( $type, $limit, &$params )
	{
		if( strpos( $limit,'-' ) )
		{
			$limit = explode('-', $limit );

			$params['min_'.$type]	= $limit[0];
			$params['max_'.$type]	= $limit[1];

		}
		else
		{
			$params['max_'.$type] = $limit;
		}

	}

	public function has( $d )
	{
		return array_key_exists( $d, $this->_p );
	}

	public static function decode( $definition )
	{
		if( empty($definition) ) return [];



		$params = explode( ':', strtolower($definition));



		foreach ( $params as $key => $param )
		{

			if( strpos( $param, '=' ) )
			{
				$kv = explode( '=', $param );
				$params[ $kv[0] ] = $kv[1];
			}

			unset($params[$key]);

		}


		if( isset($params['d']) )
		{
			$params['h'] = $params['d'];
			$params['w'] = $params['d'];
			unset($params['d']);
		}




		foreach ( static::$limit_keys as $key => $type )
		{
			if( isset( $params[$key] ) )
			{
				static::setLimit( $type, $params[$key], $params );
				unset( $params[$key] );
			}
		}

		return $params;
	}
}
