<?php namespace app;

class User extends \Jhul\Core\Application\User\_Class
{


	public function sessionStoreKey()
	{
		return 'user';
	}

	public function keyName()
	{
		return 'user_key';
	}


	public function DAOClass()
	{
		return '';
	}


}
