<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectMaintainerManagerModel
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

class ProjectMaintainerManagerModel extends RedracerBaseModel {

	protected function getRecordModelName() { return 'ProjectMaintainer'; }

	public function getMaintainersByProject(ProjectModel $projectModel) {
		$query = Doctrine_Query::create()
			->from('Users u')
			->leftJoin('u.ProjectMaintainer pm')
			->leftJoin('pm.Projects p')
			->where('p.id = ?', $projectModel['id']);
		return $query->fetchArray();
	}

	public function getProjectsByMaintainer(UserModel $userModel) {
		$query = Doctrine_Query::create()
			->from('Projects p')
			->leftJoin('p.ProjectMaintainer pm')
			->leftJoin('pm.Users u')
			->where('u.id = ?', $userModel['id']);
		return $query->fetchArray();
	}

	public function linkMaintainerToProject(UserModel $userModel, ProjectModel $projectModel) {
		$projectMaintainer = new ProjectMaintainer;
		$projectMaintainer['project'] = $projectModel['id'];
		$projectMaintainer['maintainer'] = $userModel['id'];
		$projectMaintainer->save();
	}

	public function unlinkMaintainerFromProject(UserModel $userModel, ProjectModel $projectModel) {
		$query = Docrine_Query::create()
			->delete('ProjectMaintainer pm')
			->addWhere('pm.project = ?', $projectModel['id'])
			->addWhere('pm.maintainer = ?', $userModel['id']);
		return $query->execute() > 0;
	}

}
?>
