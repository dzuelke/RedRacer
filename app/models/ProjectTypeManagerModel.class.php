<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectTypeManagerModel
 *
 * Provides access to project type records and relations. Provides the ability
 * to create and delete project type records.
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class ProjectTypeManagerModel extends RedracerBaseDoctrineManagerModel {

	protected function getIndexName() { return 'id'; }
	protected function getTableName() { return 'ProjectType'; }
	protected function getDoctrineRecordModelName() { return 'ProjectType'; }
	protected function getRecordModelName() { return 'ProjectType'; }

	public function lookupByProject(ProjectModel $projectModel) {
		return $this->lookupByIndex($projectModel['typeid']);
	}

	public function allTypesExist(array $types) {
		if (empty($types)) {
			return true;
		}
		reset($types);
		$firstType = $types[key($types)];
		if ($firstType['id'] !== null) {
			$idField = 'id';
		} elseif ($firstType['type'] !== null) {
			$idField = 'type';
		} else {
			throw new Exception('Either id or type must be given');
		}
		$idList = array();
		foreach ($types as $t) {
			$idList[] = $t[$idField];
		}
		$query = Doctrine_Query::create()
			->select('COUNT(pt.id) AS numrows')
			->from('ProjectType pt')
			->whereIn('pt.'.$idField, $idList);
		$result = $query->fetchArray();
		$numrows = $result[0]['numrows'];
		if ($numrows != count($idList)) {
			return false;
		}
		return true;
	}

}

?>
