<?php namespace Jhul\Components\Database\DAO;

trait _Edit
{

	use _WriteAccessKey;

	abstract public function url();

	public function editURL()
	{
		if( strpos( $this->url(), '?' ) )
		{
			return  $this->url().'&a=edit';
		}

		return  $this->url().'/?a=edit';
	}

	public function deleteURL()
	{
		if( strpos( $this->url(), '?' ) )
		{
			return  $this->url().'&a=delete';
		}

		return  $this->url().'/?a=delete';
	}
}
