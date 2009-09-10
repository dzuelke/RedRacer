<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Interface for Mailing Models
 * 
 * This Interface defines the minimum requirements for a Mailing class.
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage Core
 * @since      1.0
 * @version    $Id$
*/
interface RedracerIMailing
{
	/**
	 * Sends the Message
	 * 
	 * @return bool
	 */
	public function send($options = null);
	
	/**
	 * Creates a new Message
	 */
	public function newMessage();
	
	public function attach($data, $name, $type);
	
	public function embed($data, $name, $type);
	
	public function setFrom($email, $name = null);
	
	public function setReplyTo($email, $name = null);
	
	public function setTo($email, $name = null);
	
	public function setCc($email, $name = null);
	
	public function setBcc($email, $name = null);
	
	public function setSubject($subject);
	
	public function setBody($body, $type = null);
	
	public function setAltBody($body, $type);
	
	public function setPriority($priority);
	
	public function getErrors();
	
	public function hasErrors();
	
}