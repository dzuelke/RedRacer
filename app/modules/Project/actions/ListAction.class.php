<?php
// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 *
 * (Description here)
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */
class Project_ListAction extends RedracerProjectBaseAction
{

	public function execute(AgaviWebRequestDataHolder $rd) {
		// correct the projectTypes to be an array again
		// this is done to prevent errors with functions that want arrays
		// and FPF which will fatal on the ArrayObject
		$rd->setParameter(
			'projectTypes', (array)$rd->getParameter('projectTypes')
		);

		// how many records per page
		$this->setAttribute('perPage', $perPage = 20);

		// get the current page number. default is 1
		$currentPage = $rd->getParameter('page');
		if ($currentPage === null) {
			$rd->setParameter('page', $currentPage = 1);
		}

		$projectManager = $this->getContext()->getModel('ProjectManager');

		// the number of total records
		$this->setAttribute('rowCount', $projectManager->lookupRowCount());

		$projectTypeManager =
			$this->getContext()->getModel('ProjectTypeManager');
		$this->setAttribute('projectTypes', $projectTypeManager->lookupAll());

		// figure out how the list should be ordered
		// default order mode is descending
		$orderings = array();
		$orderByField = $rd->getParameter('orderby');
		if ($orderByField !== null) {
			$orderByMode = $rd->getParameter('ordermode');
			if ($orderByMode === null) {
				$orderByMode = 'DESC';
			}
			$orderings[$orderByField] = $orderByMode;
		}

		// get user model if we need to limit by user
		$user = $rd->getParameter('user');
		$userModel = null;
		if (isset($user[0])) {
			$userModel = $user[0];
		}

		$parameters = array(
			'page' => $currentPage,
			'perpage' => $perPage,
			'orderings' => $orderings,
			'user' => $userModel,
			'search' => $rd->getParameter('search'),
			'typenames' => $rd->getParameter('projectTypes')
		);
		// get the right project records
		$projects = $projectManager->lookupProjectList($parameters);
		$this->setAttribute('projects', $projects);
		
		return 'Success';
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