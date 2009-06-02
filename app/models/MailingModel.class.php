<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * (Description here)
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage Core
 * @since      1.0
 * @version    $Id$
*/
class MailingModel extends RedracerBaseModel implements AgaviISingletonModel
{
	private $defaultTransportName = null;
	
	private $transports = array();
	
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);
		$swfitConfiguration = include(AgaviConfigCache::checkConfig(AgaviConfig::get('core.config_dir') . '/mailing.xml'));
	}
}

?>
