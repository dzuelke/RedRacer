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
		// merge given 
		$swfitConfiguration = array_merge(
			include(AgaviConfigCache::checkConfig(AgaviConfig::get('core.config_dir') . '/mailing.xml')),
			$parameters
		);
		
		// setup Swift
		define('SWIFT_CLASS_DIRECTORY', $swfitConfiguration['class_dir']);
		require_once $swfitConfiguration['class_dir'] . '/Swift.php';
		Swift::registerAutoload();
		require_once $swfitConfiguration['map_dir'] . '/cache_deps.php';
		require_once $swfitConfiguration['map_dir'] . '/mime_deps.php';
		require_once $swfitConfiguration['map_dir'] . '/transport_deps.php';
		Swift_Preferences::getInstance()->setCharset($swfitConfiguration['preferences']['charset']);
		Swift_Preferences::getInstance()->setTempDir($swfitConfiguration['preferences']['temp_dir']);
		Swift_Preferences::getInstance()->setCacheType($swfitConfiguration['preferences']['cache_type']);
		foreach ($swfitConfiguration['transports'] as $name => $tp) {
			$transport = new $tp['class']();
			foreach ($tp['parameters'] as $parameter => $value) {
				call_user_func(array($transport, 'set'.ucfirst($parameter)), $value);
			}
			$this->transports[$name] = $transport;
		}
		$this->defaultTransportName = $swfitConfiguration['defaultTransport'];
	}
}

?>
