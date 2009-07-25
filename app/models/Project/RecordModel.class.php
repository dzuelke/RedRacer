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
class Project_RecordModel extends RedracerBaseRecordModel
{
  protected $defaultData = array(
		'id' => null,
		'name' => null,
		'short_description' => null,
		'long_description' => null,
		'scm_url' => null,
		'bug_tracker_url' => null,
		'date' => null
	);
}

?>