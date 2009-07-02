<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * This Model represents a User
 * 
 * The purpose of this models is, to add some more abstraction. One abstraction level is
 * the ORM, by default Doctrine, but if we would use Doctrine Classes everywhere, there would be
 * not point of having the UserManagerModel.
 * 
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @author	   Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/

class UserModel extends RedracerBaseRecordModel
{
	const SALT_LENGTH = 32;

	protected $data = array(
		'id' => null,
		'username' => null,
		'email' => null,
		'salt' => null,
		'password' => null,
		'role' => null,
		'realname' => null
	);

	/**
	 * (non-PHPdoc)
	 * @see libs/agavi/model/AgaviModel#initialize()
	 */
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);

		$this->data['role'] =
            AgaviConfig::get('org.redracer.config.user.default_group');
	}

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

	/**
	 * Checks if the provided salt is vaild
	 * 
	 * The salt is used to hash the users password so it must be valid
	 * 
	 * @param      string $salt the salt string to check
	 * @return     bool
	 */
	public function isValidSalt($salt)
	{
		return (strlen($salt) == self::SALT_LENGTH);
	}

	/**
	 * Sets userinfo from an array
	 *
	 * The given userinfo is merged with exsiting information. Any exsiting
	 * information will be overwritten by the given information
	 *
	 * @param      array $userinfo An associative array containing the user attributes
	 * @return     void
	 */
	public function fromArray(Array $userinfo)
	{
		// handle the password
		if (isset($userinfo['password']) && strlen($userinfo['password']) != 128)
		{
			// remove non vaild salt
			if (isset($userinfo['salt'])) {
				if (strlen($userinfo['salt']) == 32) {
					// salt seems to be valid, so use it
					$this->set('salt', $userinfo['salt']);
				}
				unset($userinfo['salt']);
			}
			
			$this->setPassword($userinfo['password'], false);
			unset($userinfo['password']);
		}
		// merge the rest
		$this->data = array_merge($this->data, $userinfo);
	}

}

?>
