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
	 * (non-PHPdoc)
	 * @see src/user/AgaviUser#startup()
	 */
	public function startup() {
		parent::startup();

		// Fetch the Request Data
		$reqData = $this->getContext()->getRequest()->getRequestData();

		// Only try to log the user in, if he hasn't been logged in and has
		// an autologin cookie
		if(!$this->isAuthenticated() && $reqData->hasCookie('autologon')) {
			try {
				// shorten it a bit
				$login = $reqData->getCookie('autologon');

				// we try to log the user in...
				$this->login($login['username'], $login['password'], true);
			} catch (AgaviSecurityException $e) {
				// ... if it fails we logout the user!
				$this->logout();
			}
		}
	}

	/**
	 * User login
	 * 
	 * Looks up userinfo from database and trys to authenticat the user.
	 *
	 * @param      String the username
	 * @param      String the users password, either clear text or hashed
	 * @param      bool wether the password is already hashed or not
	 * 
	 * @throws     AgaviSecurityException
	 * @return     void
	 */
	public function login($username, $password, $isPasswordHashed = false)
	{
		/**
		 * @var        UserModel
		 */
		$user = $this->getContext()->getModel('UserManager')->findOneByUsername($username);

		if($user === false) {
			throw new AgaviSecurityException('username');
		}

		// Hash the Password. No need for plaintext.
		if (!$isPasswordHashed) {
			$password = $this->computeHash($password, $user->salt);
		}

		if($password != $user->password) {
			throw new AgaviSecurityException('password');
		}

		$this->setAuthenticated(true);
		$this->clearCredentials();
		$this->revokeAllRoles();
		$this->grantRole($user->role);
		
		// Set the userinfo
		$this->setAttribute('userinfo', $user);
		
		//clear up
		unset($user, $password);
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