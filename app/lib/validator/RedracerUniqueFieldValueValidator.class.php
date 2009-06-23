<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 *
 * (Description here)
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */
class RedracerUniqueFieldValueValidator extends AgaviValidator {

	public function validate() {
		$arg = $this->getArgument();
		$data = $this->getData($arg);
		$tableManager = $this->getContext()->getModel(
			$this->getParameter('table_manager')
		);
		$fieldName = $this->getParameter('field_name');
		if (!$tableManager->isUnique($fieldName, $data)) {
			$this->throwError();
			return false;
		}
		return true;
	}

}
?>
