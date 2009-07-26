<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * (Description here)
 * 
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage %%MODULE_NAME%%
 * @since      1.0
 * @version    $Id$
*/
class Developer_RecordModel extends RedracerBaseRecordModel
{

  protected $defaultData = array(
    'id' => null,
    'name' => null,
    'email' => null,
    'password' => null,
    'salt' => null,
    'website_url' => null,
    'avatar_url' => null
  );

  /**
	 * Special mutator function for password
	 *
	 * If the password is not yet hashed a new salt and hashed password will be calculated and saved
	 *
	 * @param     string $password
	 * @param     bool $isHashed wether the password is already
	 * @return    void
	 */
	public function setPassword($password, $isHashed = false)
	{
		if ($isHashed && $this->has('salt')) {
			$this->set('password', $password);
		} else {
			/**
			 * @var RedracerUser
			 */
			$usr = $this->getContext()->getUser();
			if (!array_key_exists('salt', $this->data)) {
				$salt = $usr->computeSalt();
				$this->data['salt'] = $salt;
			}
			$this->data['password'] = $usr->computeHash($password, $this->data['salt']);
		}
	}

}

?>
