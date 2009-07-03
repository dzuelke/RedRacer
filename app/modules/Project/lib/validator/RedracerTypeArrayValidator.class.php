<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedracerTypeArrayValidatorclass
 *
 * @author eric
 */
class RedracerTypeArrayValidator extends AgaviValidator {

	public function validate() {
		$arg = $this->getArgument();
		$data = $this->getData($arg);
		$ptManager = $this->getContext()->getModel('ProjectTypeManager');
		foreach ($data as &$d) {
			$d = $ptManager->createNewModel(array('type' => $d));
		}
		if ($ptManager->allTypesExist($data)) {
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
		} else {
			$this->throwError();
			return false;
		}
	}

}
?>
