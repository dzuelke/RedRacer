<?php

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
		$u = $um->lookupUserByid($userinfo['id']);
		$u->setPassword($rd->getParameter('newpassword'));
		
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
		return 'changepassword';
	}
}

?>