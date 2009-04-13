<?php

/**
 * BaseProjectAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $projectid
 * @property string $name
 * @property string $md5
 * @property string $sha1
 * @property string $extension
 * @property enum $type
 * @property string $mime
 * @property Projects $Projects
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseProjectAttachment extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('project_attachment');
        $this->hasColumn('id', 'integer', 4, array('type' => 'integer', 'primary' => true, 'autoincrement' => true, 'length' => '4'));
        $this->hasColumn('projectid', 'integer', 4, array('type' => 'integer', 'notnull' => true, 'length' => '4'));
        $this->hasColumn('name', 'string', 120, array('type' => 'string', 'notnull' => true, 'length' => '120'));
        $this->hasColumn('md5', 'string', 32, array('type' => 'string', 'fixed' => 1, 'length' => '32'));
        $this->hasColumn('sha1', 'string', 128, array('type' => 'string', 'fixed' => 1, 'length' => '128'));
        $this->hasColumn('extension', 'string', 5, array('type' => 'string', 'fixed' => 1, 'length' => '5'));
        $this->hasColumn('type', 'enum', 4, array('type' => 'enum', 'values' => array(0 => 'file', 1 => 'dir'), 'notnull' => true, 'length' => '4'));
        $this->hasColumn('mime', 'string', 30, array('type' => 'string', 'length' => '30'));


        $this->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        $this->hasOne('Projects', array('local' => 'projectid',
                                        'foreign' => 'id'));

        $nestedset0 = new Doctrine_Template_NestedSet(array('hasManyRoots' => true, 'rootColumnName' => 'projectid'));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($nestedset0);
        $this->actAs($timestampable0);
    }
}