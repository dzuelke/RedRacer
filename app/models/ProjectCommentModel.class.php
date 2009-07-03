<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectCommentModel
 *
 * Needs description
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class ProjectCommentModel extends RedracerBaseRecordModel {

	protected $defaultData = array(
		'id' => null,
		'project' => null,
		'user' => null,
		'comment' => null,
		'date' => null
	);

	protected $user;

	public function setUser(UserModel $u) {
		$this->user = $u;
	}

	public function getUser() {
		return $this->user;
	}

}
?>
