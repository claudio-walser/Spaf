<?php
namespace Spaf\Library\Orm\Generator\Object;
/**
 * UdaColumn.php :: Represents a db column
 *
 * This class represent a db column with all properties.
 *
 * @category	GeneratorObjects
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */ 
class Column {
	
	/**
	 * Type of this column
	 * @access		private
	 * @var			string
	 */
	private $_type = '';
	
	/**
	 * Is this column a primary key?
	 * @access		private
	 * @var			bool
	 */
	private $_isPk = false;
	
	/**
	 * Is this column a foreign key?
	 * @access		private
	 * @var			bool
	 */
	private $_isFk = false;
	
	/**
	 * If this column is a foreign key, this property stores the foreign table of it
	 * @access		private
	 * @var			UdaTable
	 */
	private $_foreignTable = null;
	
	/**
	 * If this column is a foreign key, this property stores the appropriate primary key of the foreign table
	 * @access		private
	 * @var			UdaColumn
	 */
	private $_foreignColumn = null;
	
	/**
	 * If this column is a foreign key, this property stores the relation type. Equals 1:n, 1:1 or n:m
	 * @access		private
	 * @var			string
	 */
	private $_relation = '';
	
	/**
	 * If this column is a foreign key, this property stores a event wich perform the action
	 * @access		private
	 * @var			string
	 */
	private $_event = '';
	
	/**
	 * If this column is a foreign key, this property stores a the action wich should be performend on the event
	 * @access		private
	 * @var			string
	 */
	private $_action = '';
	
	/**
	 * The name of this column
	 * @access		private
	 * @var			string
	 */
	private $_name = '';
	
	/**
	 * The length of this column
	 * @access		private
	 * @var			int
	 */
	private $_size = 0;
	
	/**
	 * Is this column unsinged?
	 * @access		private
	 * @var			bool
	 */
	private $_unsigned = false;
	
	/**
	 * Can this column be null?
	 * @access		private
	 * @var			bool
	 */
	private $_null = false;
	
	/**
	 * Default value of this column
	 * @access		private
	 * @var			string
	 */
	private $_default = '';

	/**
	 * Is this column auto incrementing?
	 * @access		private
	 * @var			bool
	 */
	private $_autoincrement = false;

	/**
	 * The description of this column
	 * @access		private
	 * @var			string
	 */
	private $_description = '';
	
	
	/**
	 * constructor
	 *
	 * Instantiates the UdaColumn
	 *
	 * The constructor instante a UdaColumn object and set it's name.
	 *
	 * @param		string		name		The name of this column
	 * @access		public
	 */
	public function __construct($name) {
		$this->setName($name);
	}
	
	/**
	 * setName
	 *
	 * Set the name 
	 *
	 * Stores the given name as string in $this->_name.
	 *
	 * @param		string		name		The naem of this column
	 * @return		bool					True in any case
	 * @access		public
	 */
	public function setName($str) {
		$this->_name = (string) $str;
		return true;
	}
	
	/**
	 * setSize
	 *
	 * Set the column length 
	 *
	 * Stores the given length as string in $this->_size.
	 *
	 * @param		int			length		The length of this column
	 * @return		bool					True in any case
	 * @access		public
	 */
	public function setSize($length) {
		$this->_size = $length;
		return true;
	}
	
	/**
	 * setUnsigned
	 *
	 * Set the value whether the column is unsinged 
	 *
	 * Stores a boolean whether this column is unsinged or not.
	 * Whether this column is a primary key, unsinged is always true.
	 *
	 * @param		bool		bool		True if this column is unsigned, else false
	 * @return		bool					True in any case
	 * @access		public
	 */
	public function setUnsigned($bool) {
		if ($this->_isPk === true) {
			$bool = true;
		}
		$this->_null = (bool) $bool;
		return true;
	}
	
	/**
	 * setNull
	 *
	 * Set the value whether this column can be null 
	 *
	 * Get a boolean whether this column can be null or not.
	 *
	 * @param		bool		bool		True if this column can be null, else false
	 * @return		bool					True in any case
	 * @access		public
	 */
	public function setNull($bool) {
		$this->_null = (bool) $bool;
		return true;
	}
	
	/**
	 * getNull
	 *
	 * Get the value if this column can be null 
	 *
	 * Stores a boolean if this column can be null or not.
	 *
	 * @param		bool		bool		True if this column can be null, else false
	 * @return		bool					True in any case
	 * @access		public
	 */
	public function getNull() {
		return $this->_null;
	}
	
	public function getUnsigned() {
		return $this->_unsigned;
	}
	
	public function setDefault($def) {
		$this->_default = (string) $def;
	}
	
	public function getDefault() {
		return $this->_default;
	}
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function getSize() {
		return $this->_size;
	}
	
	public function setRelation($rel) {
		$rel = (string) $rel;
		if ($rel === '1:n' || $rel === '1:1' || $rel === 'n:m') {
			$this->_relation = $rel;
		}
	}
	
	public function getRelation() {
		return $this->_relation;
	}
	
	public function setEvent($e) {
		$e = (string) $e;
		if ($e === 'onDelete' || $e === 'onUpdate' || $e === 'onCascade') {
			$this->_event = $e;
		}
		return true;
	}
	
	public function getEvent() {
		return $this->_event;
	}
	
	public function setAction($a) {
		$a = (string) $a;
		if ($a === 'delete' || $a === 'setNull' || $a === 'ignore') {
			$this->_action = $a;
		}
	}
	
	public function getAction() {
		return $this->_action;
	}
	
	public function setAutoIncrement($bool) {
		$this->_autoincrement = (bool) $bool;
	}
	
	public function getAutoIncrement() {
		return $this->_autoincrement;
	}
	
	public function setDescription($str) {
		$this->_description = (string) $str;
	}
	
	public function setAsPrimaryKey($bool) {
		$this->_isPk = (bool) $bool;
		if ($this->_type === 'int') {
			$this->_unsigned = true;
		}
	}
	
	public function setAsForeignKey($bool) {
		$this->_unsigned = false;
		$this->_isFk = (bool) $bool;
	}
	
	public function setForeignTable(Table $table) {
		$this->_foreignTable = $table;
	}
	
	public function getForeignTable() {
		return $this->_foreignTable;
	}
	
	public function setForeignColumn(Column $column) {
		$this->_foreignColumn = $column;
	}
	
	public function getForeignColumn() {
		return $this->_foreignColumn;
	}
	
	public function setType($str) {
		$this->_type = (string) $str;
	}
	
	// Getter Methoden und is Abfrage Methoden
	public function isPk() {
		return (bool) $this->_isPk;
	}
	
	public function isFk() {
		return (bool) $this->_isFk;
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function getType() {
		return $this->_type;
	}
	
}

?>