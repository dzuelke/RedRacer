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
	 *
	 */
	public function lookupByName($name) {
		return $this->lookupOneByField('name', $name);
	}

	/**
	 * Fetches an array of project records within a range and by specific order
	 * @param	integer	$page
	 * @param	integer	$perpage
	 * @param	array	$orderings
	 * @return	array
	 */
	public function lookupProjectList(array $parameters = array()) {
		$defaults = array(
			'page' => 1,
			'perpage' => 20,
			'orderings' => array(),
			'user' => null,
			'search' => null,
			'typenames' => array(),
			'typeids' => array()
		);
		$parameters = array_merge(
			$defaults, array_intersect_key($parameters, $defaults)
		);
		extract($parameters);
		$query = Doctrine_Query::create()
			->select('*')
			->from('Projects p')
			->leftJoin('p.ProjectType pt')
			->offset(($page-1) * $perpage)
			->limit($perpage);
			
		// limit to projects belonging to a certain user
		if ($user !== null) {
			$query->leftJoin('p.ProjectMaintainer pm')
				->leftJoin('pm.Users u');
			if ($user['id'] !== null) {
				$query->where('u.id = ?', array($user['id']));
			} elseif ($user['username'] !== null) {
				$query->where('u.username = ?', array($user['username']));
			} else {
				throw new Exception(
					'User given but neither id or username is specified'
				);
			}
		}

		// search term, searches project title and project description
		if ($search !== null) {
			//$query->where('p.name LIKE :search OR p.description LIKE :search',
			//	array('search' => '%'.$search.'%')
			//);
			$query->where('p.name LIKE ? OR p.description LIKE ?',
				array('%'.$search.'%', '%'.$search.'%')
			);
		}

		// limit to particular type ids
		if (!empty($typeids)) {
			$query->whereIn('pt.id', $typeids);
		}
		// if not type ids, limit to particular type names
		elseif (!empty($typenames)) {
			$query->whereIn('pt.type', $typenames);
		}

		// order list by fields and mode
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
				array('type' => $record->ProjectType['type'])
			);
			$replicas[] = $this->recordToReplica($arrayDump);
		}
		return $replicas;
	}

	/**
	 *
	 */
	 public function lookupLatestProjects($number) {
		 $params = array(
			 'perpage' => $number,
			 'orderings' => array(
				 'created_at' => 'DESC'
			 )
		 );
		 return $this->lookupProjectList($params);
	 }

	 /**
	  *
	  */
	  public function lookupPopularProjects($number) {
		  $params = array(
			  'perpage' => $number,
			  'orderings' => array(
				  'average_rating' => 'DESC'
			  )
		  );
		  return $this->lookupProjectList($params);
	  }

}

?>
