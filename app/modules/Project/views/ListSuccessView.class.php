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
class Project_ListSuccessView extends RedracerProjectBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		$this->setAttribute('_title',
			'Project List - Page '.$rd->getParameter('page')
		);

		// Find page numbers around the current page number for pagination
		$currentPage = $rd->getParameter('page');
		$perPage = $this->getAttribute('perPage');
		$numProjects = $this->getAttribute('rowCount');
		$numPages = ceil($numProjects/$perPage);
		$pageRange = 3;
		$relevantPages = array();
		for ($i = $currentPage-$pageRange; $i <= $currentPage+$pageRange; ++$i) {
			if ($i < 1 || $i > $numPages) {
				continue;
			} else {
				$relevantPages[] = $i;
			}
		}
		if (!in_array(1, $relevantPages)) {
			array_unshift($relevantPages, 1);
		}
		if (!in_array($numPages, $relevantPages)) {
			array_push($relevantPages, $numPages);
		}
		$this->setAttribute('relevantPages', $relevantPages);

		// Create a data structure to represent the fields and their ordering
		$fieldData = array(
			array('name', 'Name', null, 'descending'),
			array('type', 'Type', null, 'descending'),
			array('average_rating', 'Avg. Rating', null, 'descending'),
			array('number_of_ratings', '# Rates', null, 'descending')
		);
		$fieldIndex = 0;
		$readableIndex = 1;
		$orderModeIndex = 2;
		$nextOrderModeIndex = 3;
		foreach ($fieldData as &$fd) {
			if ($fd[$fieldIndex] == $rd->getParameter('orderby')) {
				if ($rd->getParameter('ordermode') == 'DESC') {
					$fd[$orderModeIndex] = 'descending';
					$fd[$nextOrderModeIndex] = 'ascending';
				} else {
					$fd[$orderModeIndex] = 'ascending';
				}
			}
		}
		$this->setAttribute('fieldData', $fieldData);
		$this->setAttribute('fieldDataIndexes', array(
				'field' => $fieldIndex,
				'readable' => $readableIndex,
				'orderMode' => $orderModeIndex,
				'nextOrderMode' => $nextOrderModeIndex
			)
		);

		// have FPF automatically populate the form
		$this->getContext()->getRequest()->setAttribute(
			'populate', array('listform' => $rd),
			'org.agavi.filter.FormPopulationFilter'
		);

	}
}

?>