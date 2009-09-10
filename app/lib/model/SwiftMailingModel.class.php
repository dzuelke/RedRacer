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
abstract class SwiftMailingModel extends RedracerBaseModel implements AgaviISingletonModel, RedracerIMailing
{
	/**
	 * Name of default Transport to use
	 * @var string
	 */
	private $defaultTransport = null;
	
	/**
	 * Name of fallback Transport
	 * @var string
	 */
	private $fallbackTransport = null;

	/**
	 * Array with available transports
	 * 
	 * @var Array( name => Swift_Transport )
	 */
	private $transports = array();
	
	/**
	 * An instance of ze Message
	 * 
	 * @var Swift_Message
	 */
	private $message = null;
	
	/**
	 * Errors
	 * 
	 * @var Array
	 */
	private $errors = null;

	/**
	 * (non-PHPdoc)
	 * @see libs/agavi/model/AgaviModel#initialize($context, $parameters)
	 */
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
		$this->defaultTransport = $swfitConfiguration['defaultTransport'];
		$this->fallbackTransport = $swfitConfiguration['fallbackTransport'];
		
		// init a Message
		$this->newMessage();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see app/lib/model/RedracerIMailing#newMessage()
	 */
	public function newMessage()
	{
		$this->message = Swift_Message::newInstance();
	}
	
	/**
	 * Attaches Data to Message
	 * 
	 * @param      mixed A sting will be treated as a resourcelocator, everything else as already ready data
	 * @param      string The name of the Attachment
	 * @param      stirng The Content Type of the data
	 */
	public function attach($data, $name, $type)
	{
		if (is_string($data)) {
			$this->message->attach(Swift_Attachment::fromPath($data, $type)->setFilename($name));
		} else {
			$this->message->attach(Swift_Attachment::newInstance($data, $name, $type));
		}
	}
	
	/**
	 * Embeds Data into Message
	 * 
	 * @param      mixed A sting will be treated as a resourcelocator, everything else as already ready data
	 * @param      string The name of the Embedment
	 * @param      stirng The Content Type of the data
	 * 
	 * @return     mixed Id of embedment
	 */
	public function embed($data, $name, $type)
	{
		if (is_string($data)) {
			return $this->message->embed(Swift_EmbeddedFile::fromPath($data));
		} else {
			return $this->message->embed(Swift_EmbeddedFile::newInstance($data, $name, $type));
		}
	}
	
	public function setFrom($email, $name = null)
	{
		$this->message->setFrom($email, $name);
	}
	
	public function setReplyTo($email, $name = null)
	{
		$this->message->setReplyTo($email, $name);
	}
	
	public function setTo($email, $name = null)
	{
		$this->message->setTo($email, $name);
	}
	
	public function setCc($email, $name = null)
	{
		$this->message->setCc($email, $name);
	}
	
	public function setBcc($email, $name = null)
	{
		$this->message->setBcc($email, $name);
	}
	
	public function setSubject($subject)
	{
		$this->message->setSubject($subject);
	}
	
	public function setBody($body, $type = null)
	{
		$this->message->setBody($body, $type);
	}
	
	public function setAltBody($body, $type)
	{
		$this->message->addPart($body, $type);
	}
	
	public function setPriority($priority)
	{
		$this->message->setPriority($priority);
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	public function hasErrors()
	{
		return ($this->errors !== null);
	}
	/**
	 * Sends the Message
	 * 
	 * @param      array $options An Array with options for sending. Possible options:
	 *             <ul>
	 *               <li>transport => name of transport to use</li>
	 *             </ul>
	 * @return     bool True if messages where send, False if errors occured
	 */
	public function send($options = array())
	{
		if (isset($options['transport']) && array_key_exists($options['transport'], $this->transports)) {
			$transport = $options['transport'];
		} else {
			$transport = $this->defaultTransportName;
		}
		/**
		 * @var Swift_Mailer
		 */
		$mailer = Swift_Mailer::newInstance($this->transports[$transport]);
		
		$failures = null;
		if (!$mailer->send($this->message, $failures)) {
			$this->errors['addresses'] = $failures;
			return false;
		}
		return true;
	}
}

?>
