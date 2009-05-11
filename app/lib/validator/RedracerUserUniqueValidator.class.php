<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Validates 
 *
 * @copyright  (c) the authors
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage Validator
 * @since      1.0
 * @version    $Id$
 **/
class RedracerUserUniqueValidator extends AgaviValidator {
	public function validate()
	{
		$valid = true;
		
		$arguments = $this->getArguments();
		if (!isset($arguments['username']) && !isset($arguments['email'])) {
			throw new AgaviException('Expecting arguments "username" and "email"');
		}
		$username = $this->getData($arguments['username']);
		$email = $this->getData($arguments['email']);
		
		/**
		 * @var UserManagerModel
		 */
		$um = $this->getContext()->getModel('UserManager');
		
		if(!$um->isUnique('username', $username)) {
			$this->throwError('username', 'username');
			$valid = false;
		}
		if(!$um->isUnique('email', $email)) {
			$this->throwError('email', 'email');
			$valid = false;
		}
		
		return $valid;
	}
}
?>