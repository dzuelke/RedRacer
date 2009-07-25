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
 * @subpackage Project
 * @since      1.0
 * @version    $Id$
*/
class Project_ReadSuccessView extends RedracerProjectBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$userinfo =
			$this->getContext()->getUser()->getAttribute('userinfo');
		$developers = $this->getAttribute('developers');
		$belongsToCurrentUser = false;
		foreach ($developers as $d) {
			if ($d['name'] == $userinfo['username']) {
				$belongsToCurrentUser = true;
				break;
			}
		}
		$this->setAttribute('belongsToCurrentUser', $belongsToCurrentUser);

		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Read');
	}
}

?>