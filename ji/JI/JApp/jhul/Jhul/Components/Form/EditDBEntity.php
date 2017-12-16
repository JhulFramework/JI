<?php namespace Jhul\Components\Form;
/*----------------------------------------------------------------------------------------------------------------------
 *@author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *
 *@created Saturday 10 January 2015 03:54:05 PM IST
 *--------------------------------------------------------------------------------------------------------------------*/

abstract class EditDBEntity extends _Class
{

	public function entity()
	{
		return $this->context()->item();
	}

	public function item()
	{
		return $this->context()->item();
	}

	public function restore( $key )
	{
		if( NULL != ( $oldValue = parent::restore( $key ) ) )
		{
			return $oldValue;
		}

		if( $this->entity()->has( $key ) )
		{
			return $this->entity()->read( $key ) ;
		}
	}
}
