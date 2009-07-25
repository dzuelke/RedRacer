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
class Tag_ManagerModel extends RedracerBaseDoctrineManagerModel
{
  protected function getIndexName() { return 'id'; }
  protected function getTableName() { return 'Tag'; }
  protected function getDoctrineRecordModelName() { return 'Tag'; }
  protected function getRecordModelName() { return 'Tag.Record'; }

  public function lookupByNameIn(array $names) {
    $query = Doctrine_Query::create()
      ->select('t.id, t.name, t.description')
      ->from('Tag t')
      ->whereIn('t.name', $names);
    $results = $query->fetchArray();
    $records = array_map(array($this, 'recordToReplica'), $results);
    return $records;
  }

}

?>
