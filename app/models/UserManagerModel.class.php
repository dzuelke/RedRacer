<?php

class UserManagerModel extends RedracerBaseModel implements AgaviISingletonModel
{
	/**
	 * An array with UserModel objects
	 * 
	 * @var        Array with UserModels
	 */
	private $users = array();
	
	/**
	 * Looks up a user from the Database by his username
	 * 
	 * @param      String $username
	 * @return     Users
	 */
	public function findOneByUsername($username)
	{
		$user = Doctrine::getTable('Users')->findOneByUsername($username, Doctrine::HYDRATE_ARRAY);
		$this->users[$username] = $this->getContext()->getModel('User', null, $user);
	}
	
	/**
	 * Returns a User
	 * 
	 * @param      $username 
	 * @return     UserModel
	 */
	public function getUser($username) 
	{
		return $this->users[$username];
	}
	
	/**
	 * 
	 * 
	 * @param      $username
	 * @return     bool true if user exists, or false
	 */
	public function hasUser($username)
	{
		return array_key_exists($username, $this->users);
	}
}

?>
