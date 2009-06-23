<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Redracer Forge Project.                          |
// | Copyright (c) 2009 the Redracer Project.                                  |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * RedracerBaseDoctrineManagerModel
 *
 * To be extended by Doctrine manager models. Provides basic CRUD operations.
 *
 * @author     Eric Brisco <erisco@abstractflow.com>
 * @copyright  Authors
 * @license    GPLv3
 * @package    Redracer
 * @subpackage User
 * @since      1.0
 * @version    $Id$
 */

abstract class RedracerBaseDoctrineManagerModel extends RedracerBaseManagerModel {

	/**
	 * A reference to the Doctrine table this model acts upon
	 * @var DoctrineTable
	 */
	protected $table;

	/**
	 * Sets up the manager model
	 * @return void
	 */
	public function initialize(AgaviContext $context) {
		parent::initialize($context);
		$this->table = Doctrine::getTable($this->getTableName());
	}

	/**
	 * The Doctrine PHP-name of the table this model acts upon. Takes a guess
	 * based on class name by default.
	 * @return	string
	 */
	abstract protected function getTableName();

	/**
	 * The table index name. Returns 'id' by default.
	 * @return	string
	 */
	abstract protected function getIndexName();

	/**
	 * Returns the name of the Doctrine record model
	 * @return	string
	 */
	abstract protected function getDoctrineRecordModelName();

	/**
	 * Returns all records
	 * @return	array
	 */
	public function lookupAll() {
		$records = $this->table->findAll(Doctrine::HYDRATE_ARRAY);
		$replicas = array_map(array($this, 'recordToReplica'), $records);
		return $replicas;
	}

	/**
	 * Looks up all records within a range and ordered by field
	 * @param	integer	$offset
	 * @param	integer	$limit
	 * @param	array	$orderings
	 * @return	array
	 */
	public function lookupRangeByOrder($offset, $limit, array $orderings) {
		$tableName = $this->getTableName();
		$abbr = strtolower($tableName[0]);
		$query = Doctrine_Query::create()
			->select('*')
			->from($tableName.' '.$abbr);
		foreach ($orderings as $field => $mode) {
			$query->orderby($abbr.'.'.strtolower($field).' '.strtoupper($mode));
		}
		$query->offset($offset);
		$query->limit($limit);
		$records = $query->fetchArray();
		$replicas = array_map(array($this, 'recordToReplica'), $records);
		return $replicas;
	}

	/**
	 * Returns the number of records in the table
	 * @return	integer
	 */
	public function lookupRowCount() {
		$tableName = $this->getTableName();
		$abbr = strtolower($tableName[0]);
		$query = Doctrine_Query::create()
			->select('COUNT('.$abbr.'.'.$this->getIndexName().') c')
			->from($tableName.' '.$abbr);
		$result = $query->fetchArray();
		$row_count = $result[0]['c'];
		return $row_count;
	}

	/**
	 * Returns the record with the index given
	 * @param	integer	$index
	 * @return	object	Record object
	 */
	public function lookupByIndex($index) {
		$finder = 'findOneBy'.$this->getIndexName();
		$record = $this->table->$finder(
			$index, Doctrine::HYDRATE_ARRAY
		);
		$replica = $this->recordToReplica($record);
		return $replica;
	}

	/**
	 * Returns an array of records that match field's value
	 * @param	string		$field
	 * @param	integer|string	$value
	 * @return	array		Array of record objects
	 */
	public function lookupByField($field, $value) {
		$finder = 'findBy'.$field;
		$records = $this->table->$finder($value);
		$replicas = array_map(array($this, 'recordToReplica'), $records);
		return $replicas;
	}

	/**
	 * Returns the first record that matches the field's value
	 * @param	string		$field
	 * @param	integer|string	$value
	 * @return	object		Record object
	 */
	public function lookupOneByField($field, $value) {
		$finder = 'findOneBy'.$field;
		$record = $this->table->$finder($value);
		$replica = $this->recordToReplica($record);
		return $replica;
	}

	/**
	 * Creates a new record in the database
	 * @param	RedracerBaseRecordModel	$model
	 * @return	void
	 */
	public function insertNewRecord(RedracerBaseRecordModel $model) {
		$doctrineRecordModelName = $this->getDoctrineRecordModelName();
		$doctrineRecord = new $doctrineRecordModelName;
		$doctrineRecord->fromArray($model->toArray());
		if ($doctrineRecord->isValid()) {
			$doctrineRecord->save();
		} else {
			// TODO: this is suboptimal
			throw new AgaviException(
				$this->getDoctrineRecordModelName().' is not valid and '.
				'therefore cannot be inserted'
				);
		}
	}

	/**
	 * Updates the given record in the database
	 * @param	RedracerBaseRecordModel	$model
	 * @return	void
	 */
	public function update(RedracerBaseRecordModel $model) {
		$doctrineRecord = new $this->getDoctrineRecordModelName();
		$doctrineRecord->fromArray($model->toArray());
		if ($doctrineRecord->isValid()) {
			$doctrineRecord->save();
		} else {
			// TODO: this is suboptimal
			throw new AgaviException(
				$this->getDoctrineRecordModelName().' is not valid and '.
				'therefore cannot be updated'
				);
		}
	}

	/**
	 * Tests if the value does not exist in the given field
	 * @param	string	$field
	 * @param	integer|string	$value
	 * @return	boolean
	 */
	public function isUnique($field, $value) {
		$finder = 'findBy'.$field;
		return $this->table->$finder($value)->count() == 0;
	}

	/**
	 * Deletes the record with the index given
	 * @param	int		$index
	 * @return	boolean	True if a record was deleted
	 */
	public function deleteByIndex($index) {
		// We must not break any relationships
		return false;
		/*$tableName = $this->getTableName();
		$abbr = strtolower($tableName[0]);
		$query = Doctrine_Query::create()
			->delete($tableName.' '.$abbr)
			->where($abbr.'.'.$this->getIndexName().'='.$index);
		return $query->execute() > 0;*/
	}

	/**
	 * Creates a replica from a record
	 * @param	array|object $record
	 * @return	object
	 */
	protected function recordToReplica($record) {
		if (!is_array($record)) {
			$record = $record->toArray();
		}
		$replica = $this->getContext()->getModel(
			$this->getRecordModelName()
		);
		$replica->fromArray($record);
		return $replica;
	}

}

?>
