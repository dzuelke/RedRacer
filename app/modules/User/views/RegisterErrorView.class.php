<?php

class User_RegisterErrorView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setAttribute('_title', 'Register');
		$this->setupHtml($rd);
		$this->getLayer('content')->setTemplate('RegisterInput');
	}
}

?>