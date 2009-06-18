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
	protected function getDoctrineRecordModelName() { return 'Project'; }
	protected function getRecordModelName() { return 'Project'; }

}

?>
