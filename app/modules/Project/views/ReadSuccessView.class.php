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
 * @author     Benjamin Boerngen-Schmidt <benjamin@boerngen-schmidt.de>
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
		$maintainers = $this->getAttribute('maintainers');
		$belongsToCurrentUser = false;
		foreach ($maintainers as $m) {
			if ($m['username'] = $userinfo['username']) {
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