<?php

class User_LoginSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// for now just forward to the default index page
		return $this->createForwardContainer('Default','Index');
	}
}

?>