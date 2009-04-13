<?php

/**
 * BaseUsers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property string $role
 * @property string $realname
 * @property Doctrine_Collection $ProjectApproval
 * @property Doctrine_Collection $ProjectComments
 * @property Doctrine_Collection $ProjectMaintainer
 * @property Doctrine_Collection $ProjectRating
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseUsers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('users');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'length' => '4'));
        $this->hasColumn('username', 'string', 50, array('type' => 'string', 'notnull' => true, 'length' => '50'));
        $this->hasColumn('email', 'string', 100, array('type' => 'string', 'notnull' => true, 'length' => '100'));
        $this->hasColumn('salt', 'string', 32, array('type' => 'string', 'fixed' => 1, 'notnull' => true, 'length' => '32'));
        $this->hasColumn('password', 'string', 128, array('type' => 'string', 'fixed' => 1, 'notnull' => true, 'length' => '128'));
        $this->hasColumn('role', 'string', 30, array('type' => 'string', 'notnull' => true, 'length' => '30'));
        $this->hasColumn('realname', 'string', 120, array('type' => 'string', 'length' => '120'));


        $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasMany('ProjectApproval', array('local' => 'id',
                                                'foreign' => 'developer'));

        $this->hasMany('ProjectComments', array('local' => 'id',
                                                'foreign' => 'user'));

        $this->hasMany('ProjectMaintainer', array('local' => 'id',
                                                  'foreign' => 'maintainer'));

        $this->hasMany('ProjectRating', array('local' => 'id',
                                              'foreign' => 'user'));
    }
}