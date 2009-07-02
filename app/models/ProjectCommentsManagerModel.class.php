<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectCommentsManagerModel
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

class ProjectCommentsManagerModel extends RedracerBaseDoctrineManagerModel {

	protected function getIndexName() { return 'id'; }
	protected function getTableName() { return 'ProjectComments'; }
	protected function getDoctrineRecordModelName() { return 'ProjectComment'; }
	protected function getRecordModelName() { return 'ProjectComment'; }

	public function lookupByProjectWithUser(ProjectModel $projectModel) {
		$query = Doctrine_Query::create()
			->select('*')
			->from('ProjectComments pc')
			->leftJoin('pc.Users u')
			->where('pc.project = ?', $projectModel['id']);
		$results = $query->execute()->getData();
		$replicas = array();
		foreach ($results as $r) {
			$uReplica = $this->getContext()->getModel('User');
			$uReplica->fromArray($r->Users->toArray());
			$replica = $this->recordToReplica($r);
			$replica['user'] = $uReplica;
			$replicas[] = $replica;
		}
		return $replicas;
	}

	public function lookupByProject(ProjectModel $projectModel) {
		return $this->lookupByField('project', $projectModel['id']);
	}

	public function lookupByUser(UserModel $userModel) {
		return $this->lookupByField('user', $userModel['id']);
	}

}
?>
