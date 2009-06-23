<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedracerOrderModeValidatorclass
 *
 * @author eric
 */
class RedracerOrderModeValidator extends AgaviValidator {

	public function validate() {
		$arg = $this->getArgument();
		$data = $this->getData($arg);
		if (strtolower($data) == 'ascending') {
			$this->export('ASC', $arg);
		} elseif (strtolower($data) == 'descending') {
			$this->export('DESC', $arg);
		} else {
			$this->throwError();
			return false;
		}
		return true;
	}

}
?>
