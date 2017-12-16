<?php namespace _m\pai\context\setup_;

class Form extends \Jhul\Components\Form\_Class
{

	public function fields()
	{
		return [] ;
	}

	public function name()
	{
		return 'setup_main' ;
	}

	public function restore( $field )
	{
		$v = parent::restore($field);

		if( !empty($v) ) return $v ;

		return $this->mField()->get($field, 'default') ;
	}

}
