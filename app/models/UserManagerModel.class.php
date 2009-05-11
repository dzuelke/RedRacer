<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * 
 * (Description here)
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/

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
	 * @return     UserModel
	 */
	public function lookupUserByUsername($username)
	{
		// Query Database for Userinfo
		$user = Doctrine::getTable('Users')->findOneByUsername($username, Doctrine::HYDRATE_ARRAY);
		
		if (!$this->hasUser($user['id'])) {
			/**
			 * Fetch a new UserModel
			 *
			 * @var       UserModel
			 */
			$u = $this->getContext()->getModel('User');
			$u->fromArray($user);

			// save the User if we need him again later
			$this->users[$user['id']] = $u;
		}
		
		return $this->users[$user['id']];
	}
	
	/**
	 * Looks up a user from the Database by his userid
	 *
	 * @param      Integer the user Id
	 * @return     UserModel
	 */
	public function lookupUserById($id)
	{
		if(!$this->hasUser($id)) {
			// Query Database for Userinformation
			$user = Doctrine::getTable('Users')->findOneById($id, Doctrine::HYDRATE_ARRAY);
			/**
			 * Fetch a new UserModel
			 *
			 * @var       UserModel
			 */
			$u = $this->getContext()->getModel('User');
			$u->fromArray($user);

			// save the User if we need him again later
			$this->users[$user['id']] = $u;
		}
		
		return $this->users[$id];
	}

	/**
	 * Returns a UserModel for a given Id
	 * 
	 * Alias for lookupUserById
	 *
	 * @param      Integer the users Id
	 * @return     UserModel if the user exists in the UserManager, otherwise null
	 */
	public function getUser($id)
	{
		return $this->lookupUserById($id);
	}

	/**
	 * Checks if user was already fetched
	 *
	 * @param      int $id the user's id
	 * @return     bool true if user exists, or false
	 */
	public function hasUser($id)
	{
		return array_key_exists($id, $this->users);
	}

	/**
	 * Checks if a value is unique
	 * 
	 * @param     string $field the field name
	 * @param     mixed $value
	 * @return    bool
	 */
	public function isUnique($field, $value)
	{
		$field = 'findBy'.ucfirst($field);
		$table = Doctrine::getTable('Users');
		return ($table->$field($value)->count() == 0);
	}
	
	/**
	 * Creates a new User
	 * 
	 * Creates a new User in the Database from a UserModel instance
	 * 
	 * @param      UserModel 
	 * @return     void
	 */
	public function createNewUser(UserModel $u)
	{
		$user = new Users();
		$user->fromArray($u->toArray());
		if ($user->isValid()) {
			$user->save();
		} else {
			// TODO not nice 
			throw new AgaviException('User could not be save since he was not valid.');
		}
	}
}

?>
