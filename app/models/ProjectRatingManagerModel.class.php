<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectRatingManagerModel
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

class ProjectRatingManagerModel extends RedracerBaseManagerModel {

	protected function getIndexName() { return 'id'; }
	protected function getTableName() { return 'ProjectRating'; }
	protected function getDoctrineRecordModelName() { return 'ProjectRating'; }
	protected function getReplicaModelName() { return 'ProjectRating'; }

	public function lookupByProject(ProjectModel $projectModel) {
		return $this->lookupByField('project', $projectModel['id']);
	}

	public function lookupByUser(UserModel $userModel) {
		return $this->lookupByField('user', $userModel['id']);
	}

}

?>
