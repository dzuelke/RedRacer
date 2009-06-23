<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UniqueFieldValueValidatorclass
 *
 * @author eric
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
