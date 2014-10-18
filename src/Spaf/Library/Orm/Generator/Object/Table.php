<?php

namespace Spaf\Library\Orm\Generator\Object;

/**
 * UdaTable.php :: Represents a db table
 *
 * This class represent a db table with all properties and columns.
 *
 * @category	GeneratorObjects
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */ 
class Table {

	/**
	 * Name of this table
	 * @access		private
	 * @var			string
	 */
	private $_name = '';

	/**
	 * Description of this table
	 * @access		private
	 * @var			string
	 */
	private $_description = '';

	/**
	 * Is this an autogenerated n:m relation table?
	 * @access		private
	 * @var			bool
	 */
	private $_isRelation = false;

	/**
	 * Has this tables any foreign columns?
	 * @access		private
	 * @var			bool
	 */
	private $_hasForeignKey = false;
	
	/**
	 * All columns of this table as array
	 * @access		private
	 * @var			array
	 */
	private $_columns = array();
	
	/**
	 * All foreign keys of this table
	 * @legacy
	 * @access		private
	 * @var			array
	 */
	private $_foreignKeys = array();
	
	
	/**
	 * constructor
	 *
	 * Instantiates a UdaTable object
	 *
	 * The constructor instante a UdaTable object
	 * and stores the given name and description in internal properties.
	 *
	 * @param		string		name  			Name of this table
	 * @param		string		description  	Description of this table
	 * @access		public
	 */
	public function __construct($name, $description) {
		$this->_name = (string) $name;
		$this->_description = (string) $description;
	}
	
	/**
	 * getName
	 *
	 * Return the name of this table
	 *
	 * Get the name of this table.
	 *
	 * @return		string						The name of this table
	 * @access		public
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * setAsRelationTable
	 *
	 * Defines if this is a relation table.
	 *
	 * Set to true if this is just an autogenerated n:m relation table.
	 *
	 * @param		bool		bool  			Is this just a n:m relation table?
	 * @return		bool						True in any case
	 * @access		public
	 */
	public function setAsRelationTable($bool) {
		$this->_isRelation = (bool) $bool;
	}
	
	
	/**
	 * isRelation
	 *
	 * Return true if this is a relation table.
	 *
	 * Return true is just an autogenerated n:m relation table else false.
	 *
	 * @return		bool						True if this is just an autogenerated n:m relation table or false
	 * @access		public
	 */
	public function isRelation() {
		return $this->_isRelation;
	}
	
	/**
	 * hasForeignKey
	 *
	 * Check if this table has foreign keys.
	 *
	 * Check if this table has foreign keys.
	 *
	 * @legacy
	 * @return		bool						True if this table has foreign keys
	 * @access		public
	 */
	public function hasForeignKey() {
		return $this->_hasForeignKey;
	}
	
	/**
	 * addColumn
	 *
	 * Add a column to this table.
	 *
	 * This method adds a UdaColumn object as new column to this table.
	 *
	 * @param		UdaColumn		column		The UdaColumn object to add
	 * @return		bool						True in any case
	 * @access		public
	 */
	public function addColumn(Column $column) {
		array_push($this->_columns, $column);
		return true;
	}

	/**
	 * addForeignKey
	 *
	 * Add a foreign key to this table.
	 *
	 * Add a foreing key to this table.
	 *
	 * @legacy
	 * @param		UdaForeignKey		key		The foreign key to add
	 * @return		bool						True in any case
	 * @access		public
	 */
	public function addForeignKey(ForeignKey $key) {
		$this->_hasForeignKey = true;
		array_push($this->_foreignKeys, $key);
		return true;
	}

	/**
	 * getColumns
	 *
	 * Get all columns.
	 *
	 * Get all UdaColumn objects stored in this table.
	 *
	 * @return		array						Array with all columns
	 * @access		public
	 */
	public function getColumns() {
		return $this->_columns;
	}
	
	/**
	 * getPkString
	 *
	 * Get all primary key columns as a string imploded with underline.
	 *
	 * Get all UdaColumn objects and return them as string separated with a underline.
	 *
	 * @return		array						Array with all pk columns
	 * @access		public
	 */
	public function getPkString() {
		$cols = $this->getPkColumns();
		if ($cols !== null) {
			$c = array();
			foreach ($cols as $col) {
				$c[] = $col->getName();
			}
		}
		
		
		return implode('_', $c);
	}
	
	/**
	 * getPkColumns
	 *
	 * Get all primary key columns.
	 *
	 * Get all UdaColumn objects, wich are defined as primary key, stored in this table.
	 *
	 * @return		array						Array with all pk columns
	 * @access		public
	 */
	public function getPkColumns() {
		$return = array();
		foreach ($this->_columns as $column) {
			if ($column->isPk()) {
				$return[] = $column;
			}
		}
		return !empty($return) ? $return : null;
	}
	
	/**
	 * getPkCount
	 *
	 * Get number of pk columns.
	 *
	 * Get number of primary key columns in this table.
	 *
	 * @return		int							Number of pk columns
	 * @access		public
	 */
	public function getPkCount() {
		$i = 0;
		foreach ($this->_columns as $column) {
			if ($column->isPk()) {
				$i++;
			}
		}
		return $i;
	}
	
	/**
	 * getFkColumns
	 *
	 * Get all foreign key columns.
	 *
	 * Get all UdaColumn objects, wich are defined as foreign key, stored in this table.
	 *
	 * @return		array						Array with all fk columns
	 * @access		public
	 */
	public function getFkColumns() {
		$return = array();
		foreach ($this->_columns as $column) {
			if ($column->isFk()) {
				$return[] = $column;
			}
		}
		return !empty($return) ? $return : null;
	}
	
	/**
	 * getFkCount
	 *
	 * Get number of fk columns.
	 *
	 * Get number of foreign key columns in this table.
	 *
	 * @return		int							Number of fk columns
	 * @access		public
	 */
	public function getFkCount() {
		$i = 0;
		foreach ($this->_columns as $column) {
			if ($column->isFk()) {
				$i++;
			}
		}
		return $i;
	}
	
}

?>