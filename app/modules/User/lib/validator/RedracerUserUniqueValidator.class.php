<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Validates that a given user attribute is unique in the database
 *
 * Parameters:
 *  'attribute'     The user attribute to compare the data against. If not
 *                  provided, it defaults to the argument name.
 *  'can_match_current_user'    Allows the data to match the attribute of the
 *                              current user.
 *
 * @copyright  (c) the authors
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    User
 * @subpackage Validator
 * @since      1.0
 * @version    $Id$
 **/
class RedracerUserUniqueValidator extends AgaviValidator {
	public function validate()
	{
        if ($this->hasParameter('attribute')) {
            $attribute = $this->getParameter('attribute');
        } else {
            $attribute = $this->getArgument();
        }

		$data = $this->getData($this->getArgument());
        $context = $this->getContext();

        $okay = false;

        if ($this->hasParameter('can_match_current_user')
            && $this->getParameter('can_match_current_user')) {
            $userinfo = $context->getUser()->getAttribute('userinfo');
            if (isset($userinfo[$attribute]) && $userinfo[$attribute] == $data) {
                $okay = true;
            }
        }

        if (!$okay) {
            /**
             * @var UserManagerModel
             */
            $um = $context->getModel('UserManager');
            if(!$um->isUnique($attribute, $data)) {
                $this->throwError();
                return false;
            }
        }

        return true;
	}
}
?>