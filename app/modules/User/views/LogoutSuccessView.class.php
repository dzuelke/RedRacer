<?php

class User_LogoutSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var        FlashMessageModel
		 */
		$flash = $this->getContext()->getModel('FlashMessage');
		$flash->write('You have successfully logged out.', FlashMessageModel::MESSAGE);
		
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>