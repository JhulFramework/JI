<?php namespace Jhul\Core\Application\DataType\Types\String;

Class Definition
{

	public static function decode( $definition )
	{
		if( empty($definition) ) return [];

		$params = explode( ':', strtolower($definition));

		foreach ( $params as $key => $value );
		{


			if( !strpos($value, '=') )
			{
				throw new \Exception( 'Invalid DataType Definition "'.$definition.'-"'.$value.'"' , 1);
			}

			$kv = explode( '=', $value );
			$params[ $kv[0] ] = $kv[1];
			unset($params[$key]);
		}

		//extracting length
		if( isset( $params['l'] ) )
		{
			$length = $params['l'];

			if( strpos( $length,'-' ) )
			{
				$length = explode('-', $length );

				$params['min_length'] = $length[0];
				$params['max_length'] = $length[1];

			}
			else
			{
				$params['exact_length'] = $length;
			}

			unset($params['l']);
		}


		return $params;
	}
}
