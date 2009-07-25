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
class Release_RecordModel extends RedracerBaseRecordModel
{

  protected $defaultData = array(
    'id' => null,
    'description' => null,
    'date' => null,
    'project' => null,
    'likes' => null,
    'dislikes' => null
  );

  public function getRating() {
    if ($this['likes'] == 0 && $this['dislikes'] == 0) {
      return false;
    }
    return $this['likes'] / ($this['likes'] + $this['dislikes']);
  }

  public function getRatingPercent() {
    $rating = $this->getRating();
    if ($rating === false) {
      return false;
    }
    return round($rating * 100);
  }

  public function getNumRatings() {
    return $this['likes'] + $this['dislikes'];
  }

}

?>
