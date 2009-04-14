<?php
/**
 * Class for Flashmessages.
 * Inspired by Ruby on Rails Flash Messages.
 * 
 * @author Ross Lawley
 * @author Benjamin Boerngen-Schmidt
 *
 */
class AgaviFlashMessage extends AgaviParameterHolder {
	/**
	 * @var        AgaviContext An AgaviContext instance.
	 */
	protected $context = null;

	/**
	 * Message Level
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
	 */
	CONST INFO = 'info';

	/**
	 * Debug Level
	 */
	CONST DEBUG = 'debug';

	/**
	 * Initialize this Flash class.
	 *
	 * @param		AgaviContext	The current application context.
	 * @param 		array			An associative array of initialization parameters.
	 *
	 * @throws		<b>AgaviInitializationException</b> If an error occurs while
	 *                                                 initializing this Filter.
	 *
	 * @author		Ross Lawley
	 * @author		Benjamin Boerngen-Schmidt
	 */
	public function __construct(AgaviContext $context, array $parameters = array())
	{
		parent::__construct($parameters);
		$this->context = $context;
		
		// read flash messages from Storage
		if ($this->context->getStorage()->read('org.agavi.flash')) {
			// set parameter and empty storage.
			$this->setParameter('flash', $this->context->getStorage()->remove('org.agavi.flash'));
		} else {
			// So there are no messages in Storage
			$this->setParameter('flash', array());
		}
	}

	/**
	 * Adds a Flash message
	 *
	 * Adds A Flash message into the flash array
	 *
	 * @param		$message	object the actual message
	 * @param		$style		string The style of the message for formatting..
	 *
	 * @author		Ross Lawley
	 * @author		Benjamin Boerngen-Schmidt
	 */
	public function write($message, $style = self::MESSAGE) {
		// get a reference
		$flash =& $this->getParameter('flash');
		switch ($style) {
			case self::MESSAGE:
				$flash[self::MESSAGE][] = $message;
				break;
			case self::NOTICE:
				$flash[self::NOTICE][] = $message;
				break;
			case self::WARN:
				$flash[self::WARN][] = $message;
				break;
			case self::INFO:
				$flash[self::INFO][] = $message;
				break;
			case self::DEBUG:
				$flash[self::DEBUG][] = $message;
				break;
		}
		// write the reference into the Storage
		$this->context->getStorage()->write('org.agavi.flash', $flash);
	}

	/**
	 * Checks for flash messages
	 * 
	 * @return 		boolean		whether or not there is are any flash messages
	 *
	 * @author		Ross Lawley
	 */
	public function hasFlash($type = null) {
		if (is_null($type)) {
			$flash = $this->getParameter('flash');
			return (!empty($flash));
		} else {
			return $this->hasFlashType($style);
		}
		
	}

	/**
	 * Checks for flash messages of type $type
	 *
	 * @param		$style		Type of the Message. Must be one of the Class constants
	 * @return 		boolean		whether or not there is a flash messages of given type
	 *
	 * @author		André Fiedler
	 * @author		Benjamin Boerngen-Schmidt
	 * @author		Ross Lawley
	 */
	private function hasFlashType($style) {
		$flash = $this->getParameter('flash');
		switch ($style) {
			case self::MESSAGE:
			case self::NOTICE:
			case self::WARN:
			case self::INFO:
			case self::DEBUG:
				return (array_key_exists($style, $flash));
			default:
				return false;
		}
	}

	/**
	 * Returns the Flash Messages Array
	 *
	 * @param		$type		The type of message we want to read, if null returns all messages
	 * @return 		mixed 		<ul>
	 * 								<li>null if no flash messages exist
	 * 								<li>an array of flash messages for given $type
	 *								<li>an array with (type => messages) if $type null
	 *							</ul>
	 *
	 * @author		Ross Lawley
	 * @author		Benjamin Boerngen-Schmidt
	 * @author		André Fiedler
	 */
	function read($type = null) {
		if ($this->hasFlash($type)) {
			if(is_null($type)) {
				$this->context->getStorage()->write('org.agavi.flash', array());
				return $this->removeParameter('flash');
			} else {
				$flash =& $this->getParameter('flash');
				// copy the return
				$return = $flash[$type];
				// remove the Messages
				unset($flash[$type]);
				return $return;
			}
		} else {
			return null;
		}
	}
}
?>
