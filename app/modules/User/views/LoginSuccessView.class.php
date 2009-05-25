<?php

class User_LoginSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var        FlashMessageModel
		 */
		$flash = $this->getContext()->getModel('FlashMessage');
		$flash->write('You have successfully logged in.', FlashMessageModel::MESSAGE);

		// set the autologon cookie if requested
		if($rd->hasParameter('remember')) {
			$res = $this->getResponse();
			$res->setCookie('autologon[username]', $rd->getParameter('username'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
			$res->setCookie('autologon[password]', $this->us->getAttribute('password'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
		}

		// Check if we where redirected to the login page and redirect back
		if($this->us->hasAttribute('redirect', 'org.redracer.login')) {
			$this->getResponse()->setRedirect($this->us->removeAttribute('redirect', 'org.redracer.login'));
			return;
		}
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>