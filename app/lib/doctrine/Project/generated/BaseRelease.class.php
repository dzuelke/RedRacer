<?php

/**
 * BaseRelease
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $description
 * @property integer $date
 * @property integer $project
 * @property Project $Project
 * @property Doctrine_Collection $Files
 * @property Doctrine_Collection $Comment
 * @property Doctrine_Collection $Ratings
 * 
 * @package    Redracer
 * @subpackage Database
 * @author     Benjamin Börngen-Schmidt <benjamin@boerngen-schmidt.de>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseRelease extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('release');
        $this->hasColumn('id', 'integer', null, array('type' => 'integer', 'autoincrement' => true, 'primary' => true));
        $this->hasColumn('description', 'string', 1000, array('type' => 'string', 'length' => '1000'));
        $this->hasColumn('date', 'integer', null, array('type' => 'integer', 'notnull' => true));
        $this->hasColumn('project', 'integer', null, array('type' => 'integer', 'notnull' => true));


        $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Project', array('local' => 'project',
                                       'foreign' => 'id'));

        $this->hasMany('File as Files', array('local' => 'id',
                                              'foreign' => 'release'));

        $this->hasMany('Comment', array('local' => 'id',
                                        'foreign' => 'release'));

        $this->hasMany('Rating as Ratings', array('local' => 'id',
                                                  'foreign' => 'release'));
    }
}