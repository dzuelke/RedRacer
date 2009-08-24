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
class Release_ManagerModel extends RedracerBaseDoctrineManagerModel
{

  protected function getIndexName() { return 'id'; }
  protected function getTableName() { return 'Release'; }
  protected function getDoctrineRecordModelName() { return 'Release'; }
  protected function getRecordModelName() { return 'Release.Record'; }

  public function lookupByProject(Project_RecordModel $p) {
    $query = Doctrine_Query::create()
      ->select('r.date, r.description, r.likes, r.dislikes')
      ->from('Release r')
      ->leftJoin('Project p')
      ->orderby('r.date DESC');
    if ($p['id'] !== null) {
      $query->where('r.project = ?', $p['id']);
    } elseif ($p['name'] !== null) {
      $query->where('r.project = p.id');
      $query->andWhere('p.name = ?', $p['name']);
    } else {
      throw new Exception('Must specify project name or id');
    }
    $results = $query->fetchArray();
    $replicas = array_map(array($this, 'recordToReplica'), $results);
    return $replicas;
  }

}

?>
