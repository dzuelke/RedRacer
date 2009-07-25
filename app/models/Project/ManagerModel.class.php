<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * (Description here)
 * 
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage %%MODULE_NAME%%
 * @since      1.0
 * @version    $Id$
*/
class Project_ManagerModel extends RedracerBaseDoctrineManagerModel
{

  protected function getIndexName() { return 'id'; }
	protected function getTableName() { return 'Project'; }
	protected function getDoctrineRecordModelName() { return 'Project'; }
	protected function getRecordModelName() { return 'Project.Record'; }

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
			'search' => null,
			'tags' => array()
		);
		$parameters = array_merge(
			$defaults, array_intersect_key($parameters, $defaults)
		);
		extract($parameters);
    
		$query = Doctrine_Query::create()
			->select('p.name, p.short_description, p.date')
			->from('Project p')
			->offset(($page-1) * $perpage)
			->limit($perpage);

		// search term, searches project title and project description
		if ($search !== null) {
			$searchString = str_replace('%', '\\%', $search);
      $searchTerms = preg_split('/\s+/', $searchString);
      foreach ($searchTerms as $st) {
        $st = '%'.$st.'%';
        $query->andWhere('p.name LIKE ? OR p.short_description LIKE ?'.
                      'OR p.long_description LIKE ?',
          array($st, $st, $st)
        );
      }
		}

    // limit to particular tags
    if (!empty($tags)) {
      $oneTag = $tags[key($tags)];
      if ($oneTag['id'] !== null) {
        $tagIds = array();
        foreach ($tags as $t) {
          $tagIds[] = $t['id'];
        }
        $query->whereIn('p.Tags.id', $tagIds);
      } elseif ($oneTag['name'] !== null) {
        $tagNames = array();
        foreach ($tags as $t) {
          $tagNames[] = $t['name'];
        }
        $query->whereIn('p.Tags.name', $tagNames);
      }
    }

		// order list by fields and mode
		foreach ($orderings as $field => $mode) {
			$field = strtolower($field);
			$mode = strtoupper($mode);
			if ($field == 'tag') {
				$query->orderby('p.Tags.name '.$mode);
			} else {
				$query->orderby('p.'.$field.' '.$mode);
			}
		}

		$records = $query->fetchArray();
		$replicas = array_map(array($this, 'recordToReplica'), $records);
		return $replicas;
	}

	/**
	 *
	 */
	 public function lookupLatestProjects($number) {
		 $params = array(
			 'perpage' => $number,
			 'orderings' => array(
				 'date' => 'DESC'
			 )
		 );
		 return $this->lookupProjectList($params);
	 }

}

?>
