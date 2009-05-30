<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Succcess view for Login action
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_LoginSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var        FlashMessageModel
		 */
		$flash = $this->getContext()->getModel('FlashMessage');
		$flash->write('You have successfully logged in.', FlashMessageModel::MESSAGE);

		// set the autologon cookie if requested
		if($rd->hasParameter('remember')) {
			$res = $this->getResponse();
			$res->setCookie('autologon[username]', $rd->getParameter('username'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
			$res->setCookie('autologon[password]', $this->us->getAttribute('password'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
		}

		// Check if we where redirected to the login page and redirect back
		if($this->us->hasAttribute('redirect', 'org.redracer.login')) {
			$this->getResponse()->setRedirect($this->us->removeAttribute('redirect', 'org.redracer.login'));
			return;
		}
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>