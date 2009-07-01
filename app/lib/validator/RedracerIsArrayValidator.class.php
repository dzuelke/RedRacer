<?php

class RedracerIsArrayValidator extends AgaviValidator {

	public function validate() {
		$arg = $this->getArgument();
		$data = $this->getData($arg);
		if (!is_array($data)) {
			$this->throwError();
			return false;
		} else {
			// we export into an ArrayObject to prevent Agavi from losing
			// the array elements
			$this->export(new ArrayObject($data), $arg);
			return true;
		}
	}

}
