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
class Project_ReadAction extends RedracerProjectBaseAction
{
	public function execute(AgaviRequestDataHolder $rd) {
		// get project data
		$results = $rd->getParameter('project');
		$project = $results[0];

		// get project type
		$ptManager = $this->getContext()->getModel('ProjectTypeManager');
		$projectType = $ptManager->lookupByProject($project);
		$project['type'] = $projectType;

		// set project data
		$this->setAttribute('project', $project);

		// get and set the project comments
		$pcManager = $this->getContext()->getModel('ProjectCommentsManager');
		$comments = $pcManager->lookupByProjectWithUser($project);
		$this->setAttribute('comments', $comments);

		// get and set the project maintainers
		$pmManager = $this->getContext()->getModel('ProjectMaintainerManager');
		$maintainers = $pmManager->lookupMaintainersByProject($project);
		$this->setAttribute('maintainers', $maintainers);

		return 'Success';
	}

	public function handleError(AgaviRequestDataHolder $rd) {
		return 'Error';
	}

	/**
	 * Returns the default view if the action does not serve the request
	 * method used.
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function getDefaultViewName()
	{
		return 'Success';
	}
}

?>