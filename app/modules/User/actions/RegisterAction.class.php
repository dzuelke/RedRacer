<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * 
 * (Description here)
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/

class User_RegisterAction extends RedracerUserBaseAction
{
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var UserModel
		 */
		$u = $this->getContext()->getModel('User');
		$u->fromArray($rd->getParameters());
		/**
		 * @var  UserManagerModel
		 */
		$um = $this->getContext()->getModel('UserManager');
		try {
			$um->createNewUser($u);
			
			// TODO send mail to user with confirmation link
			return 'Success';
		} catch (AgaviException $e) {
			// TODO catch the right exceptions and use apropriate module for display
			return 'Error';
		}
	}
	
	
	public function handleError(AgaviRequestDataHolder $rd)
	{
		return 'Error';
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
}

?>