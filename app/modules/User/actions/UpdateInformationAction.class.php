<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * This action handles Update requests for userinformation
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/
class User_UpdateInformationAction extends RedracerUserBaseAction
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
		return 'Input';
	}

    /**
     * Handles the event where the POST data did not pass validation
     *
     * @return      String name of view to be called
     */
    public function handleError(AgaviRequestDataHolder $rd)
    {
        return 'Error';
    }

    /**
     * Handles the processing of valid POST data
     *
     * @return      String name of view to be called
     */
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
		$u = $um->lookupUserByid($userinfo['id']);
        $u['email'] = $rd->getParameter('email');
        $u['realname'] = $rd->getParameter('realname');

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

    /**
     * @return      Boolean true
     */
    public function isSecure() {
        return true;
    }

    /**
     * @return      String user.updateinformation
     */
    public function getCredentials() {
        return 'user.updateinformation';
    }

}

?>
