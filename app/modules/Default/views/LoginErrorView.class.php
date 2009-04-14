<?php

class Default_LoginErrorView extends RedracerDefaultBaseView
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