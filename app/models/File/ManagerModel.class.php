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
class File_ManagerModel extends RedracerBaseDoctrineManagerModel
{

  protected function getIndexName() { return 'id'; }
  protected function getTableName() { return 'File'; }
  protected function getDoctrineRecordModelName() { return 'File'; }
  protected function getRecordModelName() { return 'File.Record'; }

}

?>
