<?php

class User_ChangePasswordErrorView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'ChangePassword');
		
		// Set Template to Input
		$this->getLayer('content')->setTemplate('ChangePasswordInput');
	}
}

?>