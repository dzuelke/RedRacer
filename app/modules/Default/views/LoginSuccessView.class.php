<?php

class Default_LoginSuccessView extends RedracerDefaultBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>