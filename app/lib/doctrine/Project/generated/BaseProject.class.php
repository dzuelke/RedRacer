<?php

/**
 * BaseProject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $long_description
 * @property string $scm_url
 * @property string $bug_tracker_url
 * @property integer $date
 * @property integer $owner
 * @property Developer $Owner
 * @property Doctrine_Collection $Developers
 * @property Doctrine_Collection $Tags
 * @property Doctrine_Collection $Releases
 * 
 * @package    Redracer
 * @subpackage Database
 * @author     Benjamin Börngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseProject extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('project');
        $this->hasColumn('id', 'integer', null, array('type' => 'integer', 'autoincrement' => true, 'primary' => true));
        $this->hasColumn('name', 'string', 50, array('type' => 'string', 'notnull' => true, 'length' => '50'));
        $this->hasColumn('short_description', 'string', 200, array('type' => 'string', 'notnull' => true, 'length' => '200'));
        $this->hasColumn('long_description', 'string', 10000, array('type' => 'string', 'notnull' => true, 'length' => '10000'));
        $this->hasColumn('scm_url', 'string', 200, array('type' => 'string', 'length' => '200'));
        $this->hasColumn('bug_tracker_url', 'string', 200, array('type' => 'string', 'length' => '200'));
        $this->hasColumn('date', 'integer', null, array('type' => 'integer', 'notnull' => true));
        $this->hasColumn('owner', 'integer', null, array('type' => 'integer', 'notnull' => true));


        $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Developer as Owner', array('local' => 'owner',
                                                  'foreign' => 'id'));

        $this->hasMany('Developer as Developers', array('refClass' => 'ProjectDeveloper',
                                                        'local' => 'project',
                                                        'foreign' => 'developer'));

        $this->hasMany('Tag as Tags', array('refClass' => 'ProjectsTags',
                                            'local' => 'project',
                                            'foreign' => 'tag'));

        $this->hasMany('Release as Releases', array('local' => 'id',
                                                    'foreign' => 'project'));
    }
}