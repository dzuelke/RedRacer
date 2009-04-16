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
			$res->setCookie('autologon[username]', $rd->getParameter('username'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
			$res->setCookie('autologon[password]', $usr->getAttribute('password'), AgaviConfig::get('org.redracer.config.user.autologon_lifetime'));
		}
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>