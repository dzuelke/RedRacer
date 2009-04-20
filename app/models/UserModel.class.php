<?php

class UserModel extends RedracerBaseModel
{

	private $userinfo;
	
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);
		
		if (!is_array($parameters['userinfo'])) {
			// if no userinfo is providet
			throw new RedracerUserModelException('No useringo was given.');
		}
	}
}

class RedracerUserModelException extends AgaviException {}
?>
