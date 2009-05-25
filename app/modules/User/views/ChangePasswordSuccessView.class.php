<?php

class User_ChangePasswordSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		/**
		 * @var FlashMessageModel
		 */
		$flash = $this->getContext()->getModel('FlashMessage');
		$flash->write('Password was successfully changed.', FlashMessageModel::MESSAGE);

		// Forward to User Indexpage
		return $this->createForwardContainer('User', 'Index');
	}
}
?>