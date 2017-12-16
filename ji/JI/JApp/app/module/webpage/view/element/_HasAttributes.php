<?php namespace _m\webpage\view\element ;

trait _HasAttributes
{
	public $_attributes = [];

	protected function serializeAttributes()
	{
		$html = '';

		foreach ( $this->attributes() as $key => $value)
		{
			$html .= ' '.$key.'="'.$value.'"';
		}

		return $html;
	}

	public function attribute( $key )
	{
		if(isset( $this->attributes()[$key] ))
		{
			return $this->attributes()[$key];
		}
	}

	public function hasAttribute( $key )
	{
		return array_key_exists( $key, $this->attributes() );
	}


	final public function attributes()
	{
		return array_merge( $this->_attributes, $this->customAttributes() );
	}

	public function setAttribute( $key, $value )
	{
		$this->_attributes[$key] = $value;
		return $this ;
	}

	public function customAttributes()
	{
		return [] ;
	}
}
