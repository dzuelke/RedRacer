<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * This action handles requests for changing a user's password
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_ChangePasswordAction extends RedracerUserBaseAction
{
	
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var $um UserManagerModel
		 */
		$um = $this->getContext()->getModel('UserManager');
		
		$usr = $this->getContext()->getUser();
		$userinfo = $usr->getAttribute('userinfo');
		
		/**
		 * @var UserModel
		 */
		$u = $um->lookupByIndex($userinfo['id']);
		$u['password'] = $rd->getParameter('newpassword');
		
		// Update the User
		$um->updateUser($u);
		
		// Save new userinfo
		$usr->setAttribute('userinfo', $u->toArray());
		return 'Success';
	}
	
	/**
	 * Returns the default view if the action does not serve the request
	 * method used.
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function getDefaultViewName()
	{
		return 'Input';
	}
	
	public function isSecure()
	{
		return true;
	}
	
	public function getCredentials()
	{
		return 'user.changepassword';
	}
}

?>
