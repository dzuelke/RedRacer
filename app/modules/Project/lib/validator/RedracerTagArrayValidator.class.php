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

class RedracerTagArrayValidator extends AgaviValidator {

	public function validate() {
		$arg = $this->getArgument();
		$data = $this->getData($arg);
		$tagManager = $this->getContext()->getModel('Tag.Manager');
    $records = $tagManager->lookupAll($data);
    $i = count($data);
    foreach ($records as $r) {
      $key = array_search($r['name'], $data);
      if ($key !== false) {
        $data[$key] = $r;
        --$i;
      }
    }
		if ($i != 0) {
      $this->throwError();
      return false;
    }
    else {
      $this->export($data, $this->getParameter('selectedTagModelsExport'));
      $this->export($records, $this->getParameter('allTagModelsExport'));
      $pc = $this->getParentContainer();
			foreach ($data as $key => $v) {
				$pc->addArgumentResult(
					new AgaviValidationArgument(
						$arg.'['.$key.']',
						$this->getParameter('source')
					), AgaviValidator::SUCCESS, $this
				);
      }
      return true;
    }
	}

}
?>
