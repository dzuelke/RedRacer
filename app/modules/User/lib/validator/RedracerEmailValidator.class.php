<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Validates if the new email does not conflict with a different user
 *
 * Parameters:
 *  'can_match_current_user'    Set to true if the email can be the same as the
 *                              current user's. This is convenient when a user
 *                              may be editing his own email address, decides
 *                              not to change it, but hits "update" anyways.
 *
 * @copyright  (c) the authors
 * @author  Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    User
 * @subpackage Validator
 * @since      1.0
 * @version    $Id$
 **/

class RedracerEmailValidator extends AgaviValidator {

    public function validate()
    {
        $newEmail = $this->getData($this->getArgument());
        $context = $this->getContext();
        $okay = false;
        if ($this->hasParameter('can_match_current_user')
            && $this->getParameter('can_match_current_user')) {
            $usr = $context->getUser();
            $userinfo = $usr->getAttribute('userinfo');
            if (isset($userinfo['email']) && $userinfo['email'] == $newEmail) {
                $okay = true;
            }
        }
        if (!$okay) {
            $userManager = $context->getModel('UserManager');
            if (!$userManager->isUnique('email', $newEmail)) {
                $this->throwError();
                return false;
            }
        }
        return true;
    }

}

?>
