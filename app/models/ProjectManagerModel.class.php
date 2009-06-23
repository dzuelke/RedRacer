<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * ProjectManagerModel
 *
 * Provides access to project records and relations. Provides the ability to
 * create and delete project records.
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

class ProjectManagerModel extends RedracerBaseDoctrineManagerModel {

	protected function getIndexName() { return 'id'; }
	protected function getTableName() { return 'Projects'; }
	protected function getDoctrineRecordModelName() { return 'Projects'; }
	protected function getRecordModelName() { return 'Project'; }

	/**
	 * Fetches an array of project records within a range and by specific order
	 * @param	integer	$page
	 * @param	integer	$perpage
	 * @param	array	$orderings
	 * @return	array
	 */
	public function lookupProjectList($page, $perpage = 20, array $orderings = array()) {
		$query = Doctrine_Query::create()
			->select('*')
			->from('Projects p')
			->leftJoin('p.ProjectType pt')
			->offset(($page-1) * $perpage)
			->limit($perpage);
		foreach ($orderings as $field => $mode) {
			$field = strtolower($field);
			$mode = strtoupper($mode);
			if ($field == 'type') {
				$query->orderby('pt.type');
			} else {
				$query->orderby('p.'.$field.' '.$mode);
			}
		}
		$records = $query->execute()->getData();
		$replicas = array();
		foreach ($records as $record) {
			$arrayDump = array_merge($record->toArray(),
				array('type' =>$record->ProjectType['type'])
			);
			$replicas[] = $this->recordToReplica($arrayDump);
		}
		return $replicas;
	}

	/**
	 *
	 */
	 public function lookupLatestProjects($number) {
		 return $this->lookupProjectList(1, $number,
			 array('created_at' => 'DESC')
		 );
	 }

	 /**
	  *
	  */
	  public function lookupPopularProjects($number) {
		  return $this->lookupProjectList(1, $number,
			  array('average_rating' => 'DESC')
		  );
	  }

}

?>
