<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Error view for Login action
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_LoginErrorView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		// set the title
		$this->setAttribute('_title', 'Login');
		
		// set error messages from the user login method
		if(($error = $this->getAttribute('error')) !== null) {
			$this->container->getValidationManager()->setError($error, 'Wrong ' . ucfirst($error), 'default.Login');
		}
		
		// use the input template, default would be LoginError, but that doesn't exist
		$this->getLayer('content')->setTemplate('LoginInput');
	}
}

?>