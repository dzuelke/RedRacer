<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * This action serves the User Contontrolcenter index Page.
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_IndexAction extends RedracerUserBaseAction
{
	
	/**
	 * Generic excute function for action
	 * 
	 * We use a gerneric function here, because on POST as well as on GET Requests
	 * the Index page should be shown with the userinfo
	 * 
	 * @param      AgaviRequestDataHolder
	 * @return     String Name of view to be called
	 */
	public function execute(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var UserManagerModel
		 */
		$um = $this->getContext()->getModel('UserManager');
		$userinfo = $this->getContext()->getUser()->getAttribute('userinfo');
		
		/**
		 * @var UserModel
		 */
		$u = $um->lookupUserById($userinfo['id']);
		
		// set attibute for the view
		$this->setAttribute('user', $u);
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
		return 'Success';
	}
	
	public function isSecure()
	{
		return true;
	}
	
	public function getCredentials()
	{
		return 'user.index';
	}
}

?>