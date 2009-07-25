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

	public function execute(AgaviRequestDataHolder $rd) {
    // tag models
    if ($rd->getParameter('allTags') === null) {
      $tagManager = $this->getContext()->getModel('Tag.Manager');
      $rd->setParameter('allTags', $tagManager->lookupAll());
    }
    $this->setAttribute('allTags', $rd->getParameter('allTags'));

		// how many records per page
		$this->setAttribute('perPage', $perPage = 20);

		// get the current page number. default is 1
		$currentPage = $rd->getParameter('page');
		if ($currentPage === null) {
			$rd->setParameter('page', $currentPage = 1);
		}

		$projectManager = $this->getContext()->getModel('Project.Manager');

		// the number of total records
		$this->setAttribute('rowCount', $projectManager->lookupRowCount());

		$tagManager =
			$this->getContext()->getModel('Tag.Manager');
		$this->setAttribute('projectTags', $tagManager->lookupAll());

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

		$parameters = array(
			'page' => $currentPage,
			'perpage' => $perPage,
			'orderings' => $orderings,
			'search' => $rd->getParameter('search'),
			'tags' => $rd->getParameter('selectedTags')
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