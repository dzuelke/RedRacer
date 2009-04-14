<?php

class Default_LogoutSuccessView extends RedracerDefaultBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// for now we forward to the defaul index action
		return $this->createForwardContainer('Default', 'Index');
	}
}

?>