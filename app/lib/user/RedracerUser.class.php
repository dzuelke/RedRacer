<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Redracer User Class
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */
class RedracerUser extends AgaviRbacSecurityUser {

	/**
	 * User login
	 * 
	 * Looks up userinfo from database and trys to authenticate the user.
	 *
	 * @param      String the username
	 * @param      String the users password, either clear text or hashed
	 * @param      bool wether the password is already hashed or not
	 * 
	 * @throws     AgaviSecurityException
	 * @return     void
	 */
	public function login($email, $password, $isPasswordHashed = false)
	{
		/**
		 * @var        UserModel
		 */
    try {
      $user = $this->getContext()->getModel('Developer.Manager')->lookupByEmail($email);
    } catch (RedracerNoRecordException $e) {
      throw new AgaviSecurityException('username');
    }

		// Hash the Password. No need for plaintext.
		if (!$isPasswordHashed) {
			$password = $this->computeHash($password, $user['salt']);
		}

		if($password != $user['password']) {
			throw new AgaviSecurityException('password');
		}

		$this->setAuthenticated(true);
		$this->clearCredentials();
		$this->revokeAllRoles();
		$this->grantRole('Developer');
		
		// Set the userinfo
		$this->setAttribute('userinfo', $user->toArray());
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
	public function computeHash($password, $salt) {
		return hash_hmac('sha512', $password, $salt);
	}

	/**
	 * Performs the logout procedure
	 * 
	 * @return     void
	 */
	public function logout()
	{
		$this->killAutologonCookie();
		$this->clearCredentials();
		$this->setAuthenticated(false);
	}
	
	/**
	 * Kill the autologon Cookie
	 * 
	 * @return void
	 */
	private function killAutologonCookie() {
		$response = $this->getContext()->getController()->getGlobalResponse();
		$response->setCookie('autologon[username]', false);
		$response->setCookie('autologon[password]', false);
	}
}

?>