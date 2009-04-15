<?php

class User_UpdateInformationErrorView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'UpdateInformation');
	}
}

?>