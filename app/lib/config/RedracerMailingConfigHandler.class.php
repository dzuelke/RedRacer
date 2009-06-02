<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Complies the mailing.xml configfile
 *
 *
 *
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage Core
 * @since      1.0
 * @version    $Id$
 */
class RedracerMailingConfigHandler extends AgaviXmlConfigHandler
{
	const XML_NAMESPACE = 'http://redracer.org/config/mailing';

	public function execute(AgaviXmlConfigDomDocument $document)
	{
		// set up our default namespace
		$document->setDefaultNamespace(self::XML_NAMESPACE, 'mailing');

		$swift = array();
		$swift = $this->parseSwift($document);

		$transports = array();
		$defaultTransport = null;
		$transports = $this->parseTransports($document, $defaultTransport);
		if(!isset($transports[$defaultTransport])) {
			$error = 'Configuration file "%s" specifies undefined default transport "%s".';
			$error = sprintf($error, $document->documentURI, $defaultTransport);
			throw new AgaviConfigurationException($error);
		}

		$data = array();
		$config = array_merge($swift, array('defaultTransport' => $defaultTransport, 'transports' => $transports));
		$data[] = sprintf('return %s;', var_export($config, true));

		return $this->generate($data, $document->documentURI);
	}

	private function parseTransports(AgaviXmlConfigDomDocument $document, &$default)
	{
		// loop over the different configuration elements for transports
		foreach ($document->getConfigurationElements() as $configuration) {
			// if configuration has no transport
			if(!$configuration->has('transports')) {
				continue;
			}

			// work on the <transports> tag
			$transportsElement = $configuration->getChild('transports');
			// make sure we have a default database exists
			if(!$transportsElement->hasAttribute('default') && $default === null) {
				// missing default database
				$error = 'Configuration file "%s" must specify a default transport configuration';
				$error = sprintf($error, $document->documentURI);

				throw new AgaviParseException($error);
			}
			$default = $transportsElement->getAttribute('default');

			// work on the <transport> tags
			foreach($configuration->get('transports') as $transport) {
				$name = $transport->getAttribute('name');

				if(!isset($transports[$name])) {
					$transports[$name] = array('parameters' => array());

					if(!$transport->hasAttribute('class')) {
						$error = 'Configuration file "%s" specifies transport "%s" with missing class key';
						$error = sprintf($error, $document->documentURI, $name);

						throw new AgaviParseException($error);
					}
				}

				$transports[$name]['class'] = $transport->hasAttribute('class') ? $transport->getAttribute('class') : $transports[$name]['class'];

				$transports[$name]['parameters'] = $transport->getAgaviParameters($transports[$name]['parameters']);
			}
		}
		return $transports;
	}

	private function parseSwift(AgaviXmlConfigDomDocument $document)
	{
		$swiftDefault = array(
			'swift_dir' => AgaviConfig::get('core.vendor_dir').'/swift',
			'preferences' => array(
				'charset' => 'uft-8',
				'temp_dir' => AgaviConfig::get('core.cache_dir').'/swift',
				'cache_type' => 'disk',
		),
		);

		$swift = array();

		// loop over the different configuration elements for transports
		foreach ($document->getConfigurationElements() as $configuration) {
			// if configuration has no transport
			if(!$configuration->has('swift')) {
				continue;
			}

			$swiftElement = $configuration->getChild('swift');
			$swift = $swiftElement->getAgaviParameters();
		}

		$swiftDefault['class_dir'] = array_key_exists('swift_dir', $swift) ? $swift['swift_dir'].'/classes' : AgaviConfig::get('core.lib_dir').'/swift/classes';
		$swiftDefault['map_dir'] = array_key_exists('swift_dir', $swift) ? $swift['swift_dir'].'/dependency_maps' : AgaviConfig::get('core.lib_dir').'/swift/dependency_maps';

		return array_merge($swiftDefault, $swift);
	}
}