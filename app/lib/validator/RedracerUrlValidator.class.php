<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedracerUrlValidatorclass
 *
 * @author eric
 */
class RedracerUrlValidator extends AgaviValidator {

    public function validate() {
      $regexp = '!https?://[a-z0-9\-]+(?:\.[a-z0-9\-]+)*/?.*!is';
      $data = $this->getData($this->getArgument());
      if (preg_match($regexp, $data)) {
        return true;
      } else {
        $this->throwError();
        return false;
      }
    }

}
?>
