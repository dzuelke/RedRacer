<?php

class Default_LoginAction extends RedracerDefaultBaseAction
{
	public function executeRead(AgaviRequestDataHolder $rd)
	{
		if ($this->context->getUser()->isAuthenticated()) {
			return 'Success';
		} else {
			return 'Input';
		}
	}
	
	
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		try {
			$this->getContext()->getUser()->login($rd->getParameter('username'), $rd->removeParameter('password'));
			return 'Success';
		}
		catch (AgaviSecurityException $e) {
			$this->setAttribute('error', $e->getMessage());
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
		return 'Success';
	}
}

?>