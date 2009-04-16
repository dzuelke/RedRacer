<?php

class Default_FlashMessageSuccessView extends RedracerDefaultBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setAttribute('_flash', $this->getContext()->getModel('FlashMessage'));
		$this->setupHtml($rd, self::SLOT_LAYOUT_NAME);
	}
}

?>