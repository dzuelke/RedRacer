<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * FlashMessageModel, which is inspired by Ruby on Rails Flashmessages
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage Default
 * @since      1.0
 * @version    $Id$
*/
class FlashMessageModel extends RedracerBaseModel implements AgaviISingletonModel
{
	/**
	 * Message Level
	 * @constant MESSAGE
	 */
	CONST MESSAGE = 'message';

	/**
	 * Notice Level
	 */
	CONST NOTICE = 'notice';

	/**
	 * Warning Level
	 */
	CONST WARN = 'warn';

	/**
	 * Info Level
	 * @
	 */
	CONST INFO = 'info';

	/**
	 * Debug Level
	 */
	CONST DEBUG = 'debug';

	/**
	 * Namespace for Flashmessages
	 */
	protected $ns = 'org.redracer.flash';

	/**
	 * @var        AgaviUser
	 */
	protected $us;

	/**
	 * (non-PHPdoc)
	 * @see libs/agavi/model/AgaviModel#initialize()
	 */
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);

		$this->us = $context->getUser();
	}

	/**
	 * Indicates wether or not any flashmessages exist.
	 * 
	 * @return     bool true, if flashmessages exists, otherwise false
	 * 
	 * @author     Benjamin Börngen-Schmidt <benjamin@boerngen-schmidt.de>
	 */
	public function hasFlash()
	{
		return $this->us->hasAttributeNamespace($this->ns);
	}
	
	/**
	 * Indicates wether or not any flashmessages exist.
	 * 
	 * @param      string the type of the flashmessage
	 * @return     bool true, if flashmessages exists, otherwise false
	 * 
	 * @author     Benjamin Börngen-Schmidt <benjamin@boerngen-schmidt.de>
	 */
	public function hasFlashType($type)
	{
		return $this->us->hasAttribute($type, $this->ns);
	}

	/**
	 * Returns the Flash Messages Array
	 *
	 * @param      $type		The type of message we want to read, if null returns all messages
	 * @return     mixed 		<ul>
	 * 								<li>null if no flash messages exist
	 * 								<li>an array of flash messages for given $type
	 *								<li>an array with (type => messages) if $type null
	 *							</ul>
	 *
	 * @author     Benjamin B√∂rngen-Schmidt <benjamin@boerngen-schmidt.de>
	 */
	public function read($type = null)
	{
		switch ($type) {
			case self::MESSAGE:
			case self::NOTICE:
			case self::WARN:
			case self::INFO:
			case self::DEBUG:
				$retval = $this->us->removeAttribute($type, $this->ns);
				break;
			default:
				$retval = $this->us->removeAttributeNamespace($this->ns);
		}
		return $retval;
	}


	/**
	 * Adds A Flash message into the flash array
	 *
	 * @param		$message	object the actual message
	 * @param		$type		string The style of the message for formatting
	 *
	 * @author		Benjamin Boerngen-Schmidt
	 */
	public function write($message, $type = self::MESSAGE)
	{
		switch ($type) {
			case self::MESSAGE:
			case self::NOTICE:
			case self::WARN:
			case self::INFO:
			case self::DEBUG:
				$this->us->appendAttribute($type, $message, $this->ns);
				break;
			default:
				throw new FlashMessageException('No vaild messagetype given.');
		}
	}
}

class FlashMessageException extends Exception {}
?>
