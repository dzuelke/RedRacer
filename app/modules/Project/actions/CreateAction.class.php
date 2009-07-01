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
class Project_CreateAction extends RedracerProjectBaseAction
{

	public function executeRead(AgaviWebRequestDataHolder $rd) {
		$this->setTypeList();
		return 'Input';
	}

	public function executeWrite(AgaviWebRequestDataHolder $rd) {

		// put the project in the database
		$projectManager = $this->getContext()->getModel('ProjectManager');
		$newProject = $projectManager->createNewModel();
		$newProject['name'] = $rd->getParameter('name');
		$newProject['typeid'] = $rd->getParameter('type');
		$newProject['description'] = $rd->getParameter('description');
		$projectManager->insertNewRecord($newProject);

		// lookup the new project to get its id
		$newProject = $projectManager->lookupByName($newProject['name']);

		// get the current user and load him into a model
		$userModel = $this->getContext()->getModel('User');
		$userModel->fromArray(
			$this->getContext()->getUser()->getAttribute('userinfo')
		);

		// link the user to the project
		$projectMaintainerManager =
			$this->getContext()->getModel('ProjectMaintainerManager');
		$projectMaintainerManager
			->linkMaintainerToProject($userModel, $newProject);
		

		return 'Success';
	}

	public function handleWriteError(AgaviWebRequestDataHolder $rd) {
		$this->setTypeList();
		return 'Error';
	}

	public function isSecure() {
		return true;
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
		return 'Input';
	}

	protected function setTypeList() {
		// get a list of project types
		$projectTypeManager = $this->getContext()->getModel('ProjectTypeManager');
		$types = $projectTypeManager->lookupAll();
		$this->setAttribute('projectTypes', $types);
	}

}

?>