<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * RedracerBaseRecordModel
 *
 * To be extended by record models. Provides ArrayAccess and magic method
 * implementation for field value access. Provides loading fields and values
 * from an array and exporting fields and values to an array.
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class RedracerBaseRecordModel extends RedracerBaseModel implements ArrayAccess {

	/**
	 * A map of field names to corresponding values
	 * @var array
	 */
	protected $data = array();

	/**
	 * Reference to the manager for this model
	 * @var RedracerBaseManagerModel
	 */
	protected $manager;

	/**
	 * Loads fields and values from an array
	 * @param	array	$data
	 * @return	void
	 */
	public function fromArray(array $data) {
		$this->data = $data;
	}

	/**
	 * Exports fields and values to an array
	 * @return	array
	 */
	public function toArray() {
		return $this->data;
	}

	/**
	 * Tests if a field can both be got and set (Automatically called in
	 * ArrayAccess)
	 * @return	boolean
	 */
	public function offsetExists($offset) {
		$getter = 'get'.$offset;
		$setter = 'set'.$offset;
		if (method_exists($this, $getter) && method_exists($this, $setter)) {
			return true;
		} else {
			return array_key_exists($offset, $this->data);
		}
	}

	/**
	 * Gets a field's value (Automatically called in ArrayAccess)
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function offsetGet($offset) {
		$getter = 'get'.$offset;
		if (method_exists($this, $getter)) {
			return $this->$getter();
		} else {
			if (array_key_exists($offset, $this->data)) {
				return $this->data[$offset];
			} else {
				throw new RedracerRecordAttributeExpception(
					'Attribute "'.$offset.'" does not exist'
				);
			}
		}
	}

	/**
	 * Sets a field's value (Automatically called in ArrayAccess)
	 * @param	string	$offset
	 * @param	mixed	$value
	 * @return	void
	 */
	public function offsetSet($offset, $value) {
		$setter = 'set'.$offset;
		if (method_exists($this, $setter)) {
			$this->$setter($value);
		} else {
			if (array_key_exists($offset, $this->data)) {
				$this->data[$offset] = $value;
			} else {
				throw new RedracerRecordAttributeException(
					'Attribute "'.$offset.'" does not exist'
				);
			}
		}
	}

	/**
	 * @throws RedracerProjectModelAttributeException
	 */
	public function offsetUnset($offset) {
		throw new RedracerRecordAttributeException(
			'Attribte "'.$offset.'" cannot be unset'
		);
	}

	/**
	 * Magic method to get a field (returns a call to offsetGet)
	 * @param	string	$offset
	 * @return	mixed
	 */
	public function __get($offset) {
		return $this->offsetGet($offset);
	}

	/**
	 * Magic method to set a field (calls offsetSet)
	 * @param	string	$offset
	 * @param	mixed	$value
	 * @return	void
	 */
	public function __set($offset, $value) {
		$this->offsetSet($offset, $value);
	}

}

class RedracerRecordException {}
class RedracerRecordAttributeException extends RedracerRecordException {}

?>
