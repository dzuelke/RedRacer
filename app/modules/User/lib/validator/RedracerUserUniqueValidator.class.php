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
 * @package    User
 * @subpackage Validator
 * @since      1.0
 * @version    $Id$
 **/
class RedracerUserUniqueValidator extends AgaviValidator {
	public function validate()
	{
		$argument = $this->getArgument();
		$data = $this->getData($argument);
		
		/**
		 * @var UserManagerModel
		 */
		$um = $this->getContext()->getModel('UserManager');
		
		if($um->isUnique($argument, $data)) {
			return true;
		}
		
		$this->throwError();
		return false;
	}
}
?>