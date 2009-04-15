<?php

class User_LogoutSuccessView extends RedracerUserBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// for now we forward to the defaul index action
		return $this->createForwardContainer('Default', 'Index');
	}
}

?>