<?php
namespace Spaf\Library\Orm\Generator\Query\Template;

/**
 * UdaSqlTemplate.php :: Abstract base class for any sql template
 *
 * This is a abstract base class for any sql template class.
 * SQL Template classe just store some strings for setup queries.
 *
 * @abstract
 * @category	SqlTemplate
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */ 
abstract class Sql {
	
	/**
	 * Define if this dbms can use backticks or not
	 * @access		protected
	 * @var			bool
	 */
	protected $_hasBackticks = false;
	
	/**
	 * Define some internal strings
	 * @access		protected
	 * @var			array
	 */
	protected $_internals = array(
		'unsigned' => '',
		'null' => '',
		'not_null' => '',
		'default' => '',
		'auto_increment' => '',
		'comment' => '',
	);
	
	/**
	 * Define the column templates for setup queries
	 * @access		protected
	 * @var			array
	 */
	protected $_columnTemplates = array(
		'bigint' => '',
		'binary' => '',
		'bit' => '',
		'blob' => '',
		'bool' => '',
		'char' => '',
		'clob' => '',
		'date' => '',
		'datetime' => '',
		'decimal' => '',
		'double' => '',
		//'enum' => '',
		'float' => '',
		'int' => '',
		'longblob' => '',
		'longtext' => '',
		'mediumblob' => '',
		'mediumint' => '',
		'mediumtext' => '',
		//'set' => '',
		'smallint' => '',
		'text' => '',
		'time' => '',
		'timestamp' => '',
		'tinyblob' => '',
		'tinyint' => '',
		'tinytext' => '',
		'varbinary' => '',
		'varchar' => '',
		'year' => ''
	);
	
	/**
	 * Define max length of any column type
	 * @access		protected
	 * @var			array
	 */
	protected $_columnMaxLength = array(
		'bigint' => 0,
		'binary' => 0,
		'bit' => 0,
		'blob' => 0,
		'bool' => 0,
		'char' => 0,
		'clob' => 0,
		'date' => 0,
		'datetime' => 0,
		'decimal' => 0,
		'double' => 0,
		//'enum' => 0,
		'float' => 0,
		'int' => 0,
		'longblob' => 0,
		'longtext' => 0,
		'mediumblob' => 0,
		'mediumint' => 0,
		'mediumtext' => 0,
		//'set' => 0,
		'smallint' => 0,
		'text' => 0,
		'time' => 0,
		'timestamp' => 0,
		'tinyblob' => 0,
		'tinyint' => 0,
		'tinytext' => 0,
		'varbinary' => 0,
		'varchar' => 0,
		'year' => 0
	);
	
	/**
	 * Define the create table string
	 * @access		protected
	 * @var			string
	 */
	protected $_tableCreateString = '';
	
	/**
	 * Define the string for foreing columns
	 * @access		protected
	 * @var			string
	 */
	protected $_foreignKeyString = '';

	/**
	 * Define the string for primary keys in setup queries
	 * @access		protected
	 * @var			string
	 */
	protected $_primaryKeyString = '';
	
	/**
	 * Define the table ending string
	 * @access		protected
	 * @var			string
	 */
	protected $_tableCloseString = '';
	
	/**
	 * getColumnTemplateString
	 *
	 * Return the template string of a column type.
	 *
	 * This method return the template string for any specified column type
	 * or null if the column type doesn't exist.
	 * All types can be found in the get started section of www.uda.uwd.ch
	 *
	 * @param		string			Column type
	 * @return		string			Template string for this column type or null if this type does not exist
	 * @access		public
	 */
	public function getColumnTemplateString($columType) {
		return isset($this->_columnTemplates[$columType]) ? $this->_columnTemplates[$columType] : null;
	}
	
	/**
	 * getCreateTable
	 *
	 * Return the create table string.
	 *
	 * This method return create table string.
	 *
	 * @return		string			Create table string
	 * @access		public
	 */
	public function getCreateTable() {
		return $this->_tableCreateString;
	}

	/**
	 * getPkString
	 *
	 * Return the primary key string.
	 *
	 * This method return primary key string.
	 *
	 * @return		string			Primary key string
	 * @access		public
	 */
	public function getPkString() {
		return $this->_primaryKeyString;
	}

	/**
	 * getFkString
	 *
	 * Return the foreign key string.
	 *
	 * This method return foreign key string.
	 *
	 * @return		string			Foreign key string
	 * @access		public
	 */
	public function getFkString() {
		return $this->_foreignKeyString;
	}

	/**
	 * getCloseTable
	 *
	 * Return the table ending string.
	 *
	 * This method return table ending string.
	 *
	 * @return		string			Table ending string
	 * @access		public
	 */
	public function getCloseTable() {
		return $this->_tableCloseString;
	}
	
	/**
	 * getUnsigned
	 *
	 * Return the unsigned internal.
	 *
	 * This method return the unsigned internal.
	 *
	 * @return		string			Unsigned internal
	 * @access		public
	 */
	public function getUnsigned() {
		return $this->_internals['unsigned'];
	}
	
	/**
	 * getNull
	 *
	 * Return the null internal.
	 *
	 * This method return the null internal.
	 *
	 * @return		string			Null internal
	 * @access		public
	 */
	public function getNull() {
		return $this->_internals['null'];
	}
	
	/**
	 * getNotNull
	 *
	 * Return the not_null internal.
	 *
	 * This method return the not_null internal.
	 *
	 * @return		string			Not null internal
	 * @access		public
	 */
	public function getNotNull() {
		return $this->_internals['not_null'];
	}
	
	/**
	 * getDefault
	 *
	 * Return the default internal.
	 *
	 * This method return the default internal.
	 *
	 * @return		string			Default internal
	 * @access		public
	 */
	public function getDefault() {
		return $this->_internals['default'];
	}
	
	/**
	 * getAutoIncrement
	 *
	 * Return the auto_increment internal.
	 *
	 * This method return the auto_increment internal.
	 *
	 * @return		string			Auto increment internal
	 * @access		public
	 */
	public function getAutoIncrement() {
		return $this->_internals['auto_increment'];
	}
	
	/**
	 * getComment
	 *
	 * Return the comment internal.
	 *
	 * This method return the comment internal.
	 *
	 * @return		string			Comment internal
	 * @access		public
	 */
	public function getComment() {
		return $this->_internals['comment'];
	}

}


?>