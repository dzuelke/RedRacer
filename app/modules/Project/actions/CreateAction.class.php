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

	public function executeRead(AgaviRequestDataHolder $rd) {
		$this->setTagList();
		return 'Input';
	}

	public function executeWrite(AgaviRequestDataHolder $rd) {

		// put the project in the database
		$projectManager = $this->getContext()->getModel('Project.Manager');
		$newProject = $projectManager->createNewModel();
		$newProject['name'] = $rd->getParameter('name');
		$newProject['short_description'] = $rd->getParameter('short_description');
		$newProject['long_description'] = $rd->getParameter('long_description');
    $newProject['scm_url'] = $rd->getParameter('scm_url');
    $newProject['bug_tracker_url'] = $rd->getParameter('bug_tracker_url');
    $newProject['date'] = time();

		// link the user to the project
    $userinfo = $this->getContext()->getUser()->getAttribute('userinfo');
    $newProject['owner'] = $userinfo['id'];

		$projectManager->insertNewRecord($newProject);

		// lookup the new project to get its id
		$newProject = $projectManager->lookupByName($newProject['name']);

    // give tags to the project
    $projectManager->addTagsTo($newProject, $rd->getParameter('selectedTags'));

		return 'Success';
	}

	public function handleWriteError(AgaviRequestDataHolder $rd) {
		$this->setTagList();
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

	protected function setTagList() {
		// set a list of tags
		$tm = $this->getContext()->getModel('Tag.Manager');
		$tags = $tm->lookupAll();
		$this->setAttribute('tags', $tags);
	}

}

?>