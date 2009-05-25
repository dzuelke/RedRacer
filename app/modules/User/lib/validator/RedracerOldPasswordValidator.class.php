<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Validates if the enterd old password machtes the one in DB
 *
 * @copyright  (c) the authors
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    User
 * @subpackage Validator
 * @since      1.0
 * @version    $Id$
 **/
class RedracerOldPasswordValidator extends AgaviValidator {
	public function validate()
	{
		$oldPassword = $this->getData($this->getArgument());
		
		/**
		 * @var RedracerUser
		 */
		$usr = $this->getContext()->getUser();
		$userinfo = $usr->getAttribute('userinfo');
		
		if (isset($userinfo['salt']) && isset($userinfo['password'])) {
			// hash the entered old PW
			$hashedPassword = $usr->computeHash($oldPassword, $userinfo['salt']);
			if($hashedPassword != $userinfo['password']) {
				$this->throwError();
				return false;
			}
		} else {
			// Oops seems like the userinfo was gone...
			throw new AgaviException('Userinfo was not found');
		}
		
		// Okay everythings fine
		return true;
	}
}
?>