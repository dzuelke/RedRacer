<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectModel
 *
 * Need description
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class ProjectModel extends RedracerBaseRecordModel implements ArrayAccess {

	protected $defaultData = array(
		'id' => null,
		'typeid' => null,
		'name' => null,
		'description' => null,
		'average_rating' => null,
		'number_of_ratings' => null,
		'created_at' => null
	);

	protected $type;

	public function setType(ProjectTypeModel $type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

}

?>
