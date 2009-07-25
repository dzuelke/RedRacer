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
		// get & set project data
		$results = $rd->getParameter('project');
		$project = $results[0];
    $this->setAttribute('project', $project);

		// get and set project tags
		$pm = $this->getContext()->getModel('Project.Manager');
		$tags = $pm->lookupTagsFor($project);
		$this->setAttribute('tags', $tags);	

    // get and set project developers
    $developers = $pm->lookupDevelopersFor($project);
    $this->setAttribute('developers', $developers);

    // get and set releases
    $releases = $pm->lookupReleasesFor($project);
    $this->setAttribute('releases', $releases);
    if (count($releases) >= 1) {
      $this->setAttribute('latestRelease', $releases[0]);
    } else {
      $this->setAttribute('latestRelease', false);
    }  

    // get and set current project rating
    try {
      $rating = $pm->calculateRatingWith($releases);
      $this->setAttribute('rating', $rating);
    } catch (RedracerNoRecordException $e) {
      $this->setAttribute('rating', false);
    }

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