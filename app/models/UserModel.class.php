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
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
*/

class UserModel extends RedracerBaseModel implements ArrayAccess
{
	const SALT_LENGTH = 32;

	/**
	 * Holds the user attributes
	 * @var        Array
	 */
	private $data;

	/**
	 * (non-PHPdoc)
	 * @see libs/agavi/model/AgaviModel#initialize()
	 */
	public function initialize(AgaviContext $context, array $parameters = array())
	{
		parent::initialize($context, $parameters);

		$this->data = array(
            'role' => AgaviConfig::get('org.redracer.config.user.default_group')
        );
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

	/**
	 * Returns the Userinformation as an Array
	 *
	 * @return      Array containing the Userinformation
	 */
	public function toArray()
	{
		return $this->data;
	}

    /**
     * @return      Boolean true if the attribute exists
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @return      Mixed the attribute value or null if it does not exist
     */
    public function offsetGet($offset)
    {
        $getter = 'get'.$offset;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            return isset($this->data[$offset]) ? $this->data[$offset] : null;
        }
    }

    /**
     * Sets the attribute to the given value
     *
     * @return      void
     */
    public function offsetSet($offset, $value)
    {
        $setter = 'set'.$offset;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Always throws an exception
     *
     * @throws RedracerUserModelException
     */
    public function offsetUnset($offset)
    {
        throw new RedracerUserModelException('Not allowed to unset attributes.');
    }

	/**
	 * Convinience function
	 *
	 * Provides easier access to user attributes
	 *
	 * @param      string $name name of the property
	 * @return     mixed
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}

		return null;
	}

	/**
	 * Convinience function
	 *
	 * Verifies wether a user attribute exists
	 *
	 * @param      string $name name of the user attribute
	 * @return     bool
	 */
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

}

class RedracerUserModelException extends AgaviException {}
?>
