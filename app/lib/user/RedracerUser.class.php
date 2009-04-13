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
 * @copyright  (c) the authors
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class RedracerUser extends AgaviRbacSecurityUser {
	public function login($username, $password, $isPasswordHashed = false)
	{
		$user = Doctrine::getTable('Users')->findOneBy('username', $username);
		
		if($user === false) {
			throw new AgaviSecurityException('username');
		}
echo '<pre>', var_dump($user), '</pre>'; exit();
		$password = $this->computeHash($password, $user->salt);

		if($password != $user->getPassword()) {
			throw new AgaviSecurityException('password');
		}

		$this->setAuthenticated(true);
		$this->clearCredentials();
		$this->grantRole($user->getRole());
	}
	
	/**
	 * Computes a random salt
	 * 
	 * @return		string A random Salt
	 */
	public function computeSalt() {
		return sha1(uniqid(rand(), true));
	}
	
	/**
	 * Computes the hash of a password with a given salt
	 * 
	 * @param		string the cleartext password
	 * @param		string the salt
	 * @return		string the computed salted hash of the password
	 */
	private function computeHash($password, $salt) {
		return hash_hmac('sha512', $password, $salt);
	}

	/**
	 * Performs the logout procedure
	 */
	public function logout()
	{
		$this->clearCredentials();
		$this->setAuthenticated(false);
	}
}

?>