<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * RedracerBaseManagerModel
 *
 * To be extended by manager models
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

abstract class RedracerBaseManagerModel extends RedracerBaseModel implements AgaviISingletonModel {

	/**
	 * Returns the record model name
	 * @return	string
	 */
	abstract protected function getRecordModelName();

	/**
	 * Creates a new model
	 * @return	object
	 */
	public function createNewModel() {
		return $this->getContext()->getModel($this->getRecordModelName());
	}

}

?>
