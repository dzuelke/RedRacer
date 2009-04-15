<?php

class User_ForgotPasswordInputView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'ForgotPassword');
	}
}

?>