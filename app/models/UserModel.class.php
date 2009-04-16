<?php

class UserModel extends RedracerBaseModel
{

	/**
	 * Looks up a user from the Database by his username
	 * 
	 * @param      String $username
	 * @return     Users
	 */
	public function findOneByUsername($username)
	{
		return Doctrine::getTable('Users')->findOneByUsername($username);
	}
}

?>
