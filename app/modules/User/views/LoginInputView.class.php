<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Input view for Login action
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_LoginInputView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Login');

		if($this->getContainer()->hasAttributeNamespace('org.agavi.controller.forwards.login')) {
			// we were redirected to the login form by the controller because the requested action required security
			// so store the input URL in the session for a redirect after login
			$this->us->setAttribute('redirect', $this->rq->getUrl(), 'org.redracer.login');
		} else {
			// clear the redirect URL just to be sure
			// but only if request method is "read", i.e. if the login form is served via GET!
			$this->us->removeAttribute('redirect', 'org.redracer.login');
		}
	}
}

?>