<?php namespace Jhul\Core\Application\Module;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 2017-june-2
|
| Form Fields Configuration
+---------------------------------------------------------------------------------------------------------------------*/

class delete_FormFields
{

	private $_fields ;

	public function __construct( $fields )
	{
		$this->_fields = $fields ;
	}

	public function getDefinition( $f )
	{
		if( is_array( $f ) )
		{
			$fields = [];

			foreach ( $f as $n)
			{
				$fields[$n] = $this->getDefinition( $n );
			}

			return $fields;
		}

		if( isset( $this->_fields[$f] ) )
		{
			if( isset( $this->_fields[$f]['definition'] ) )return $this->_fields[$f]['definition'];

			throw new \Exception( 'Definition Not Set For Form Field "'.$f.'" ' , 1);
		}

		throw new \Exception( 'Form Field "'.$f.'" not defined !' , 1);

	}
}
