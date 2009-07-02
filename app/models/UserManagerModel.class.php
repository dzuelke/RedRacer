<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Manager Model for Users
 *
 * The Model is the only place which interacts with the Database, so if you want to use
 * RAW SQL or another ORM like Propel as Background, you will just need to exchange this class,
 * everything else will remain.
 *
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class UserManagerModel extends RedracerBaseDoctrineManagerModel
{

	public function getTableName() { return 'Users'; }
	public function getIndexName() { return 'id'; }
	public function getRecordModelName() { return 'User'; }
	public function getDoctrineRecordModelName() { return 'Users'; }

	/**
	 * Looks up a user from the Database by his username
	 *
	 * @param      String $username
	 * @return     UserModel
	 */
	public function lookupUserByUsername($username)
	{
		return $this->lookupOneByField('username', $username);
	}

	/**
	 * Looks up a user from the Database by his userid
	 *
	 * @param      Integer the user Id
	 * @return     UserModel
	 */
	public function lookupUserById($id)
	{
		return $this->lookupOneByField('id', $id);
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
	 * This will always return false because there is currently no caching
	 * mechanism
	 *
	 * @param      int $id the user's id
	 * @return     bool true if user exists, or false
	 */
	public function hasUser($id)
	{
		return false;
	}

	/**
	 * Creates a new User
	 *
	 * Creates a new User in the Database from a UserModel instance
	 * Alias to insertNewRecord
	 *
	 * @param      UserModel
	 * @return     void
	 */
	public function createNewUser(UserModel $u)
	{
		$this->insertNewRecord($u);
	}

	/**
	 * Updates a User
	 *
	 * Alias to update
	 *
	 * @param	UserModel	$u
	 * @return	void
	 */
	public function updateUser(UserModel $u)
	{
		$this->update($u);
	}
}

?>
