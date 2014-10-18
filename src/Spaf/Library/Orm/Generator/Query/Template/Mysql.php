<?php
namespace Spaf\Library\Orm\Generator\Query\Template;

/**
 * UdaMysqlTemplate.php :: Abstract base class for mysql4 and mysql5 template
 *
 * This is a abstract base class for the final for mysql4 and mysql5 template classes.
 *
 * @abstract
 * @category	SqlTemplate
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */ 
abstract class Mysql extends Sql {
	
	/**
	 * Define if this dbms can use backticks or not
	 * @access		protected
	 * @var			bool
	 */
	protected $_hasBackticks = true;
	
	/**
	 * Define some internal strings
	 * @access		protected
	 * @var			array
	 */
	protected $_internals = array(
		'unsigned' => 'UNSIGNED',
		'null' => 'NULL',
		'not_null' => 'NOT NULL',
		'default' => 'DEFAULT',
		'auto_increment' => 'AUTO_INCREMENT',
		'comment' => 'COMMENT',
	);
	
	/**
	 * Define the column templates for setup queries
	 * @access		protected
	 * @var			array
	 */
	protected $_columnTemplates = array(
		'bigint'		=> "\t`{columnname}` BIGINT ({size}) {null} {default} {description},\n",
		'binary'		=> "\t`{columnname}` BINARY ({size}) {null} {description},\n",
		'bit'			=> "\t`{columnname}` BIT ({size}) {null} {default} {description},\n",
		'blob'			=> "\t`{columnname}` BLOB {null} {default} {description},\n",
		'bool'			=> "\t`{columnname}` BOOL {null} {default} {description},\n",
		'char'			=> "\t`{columnname}` CHAR ({size}) {null} {default} {description},\n",
		'clob'			=> "\t`{columnname}` CLOB {null} {default} {description},\n",
		'date'			=> "\t`{columnname}` DATE {null} {default} {description},\n",
		'datetime'		=> "\t`{columnname}` DATETIME {null} {default} {description},\n",
		'decimal'		=> "\t`{columnname}` DECIMAL ({size}) {null} {default} {description},\n",
		'double'		=> "\t`{columnname}` DOUBLE {null} {default} {description},\n",
		'enum'			=> "\t`{columnname}` ENUM ({size}) {null} {default} {description},\n",
		'float'			=> "\t`{columnname}` FLOAT {null} {default} {description},\n",
		'int'			=> "\t`{columnname}` INT ({size}) {unsigned} {null} {default} {auto_increment} {description},\n",
		'longblob'		=> "\t`{columnname}` LONGBLOB {null} {default} {description},\n",
		'longtext'		=> "\t`{columnname}` LONGTEXT {null} {description},\n",
		'mediumblob'	=> "\t`{columnname}` MEDIUMBLOB {null} {description},\n",
		'mediumint'		=> "\t`{columnname}` MEDIUMINT ({size}) {unsigned} {null} {default} {auto_increment} {description},\n",
		'mediumtext'	=> "\t`{columnname}` MEDIUMTEXT {null} {description},\n",
		//'set' 		=> '',
		'smallint' 		=> "\t`{columnname}` SMALLINT ({size}) {null} {default} {description},\n",
		'text' 			=> "\t`{columnname}` TEXT {null} {description},\n",
		'time' 			=> "\t`{columnname}` TIME {null} {default} {description},\n",
		'timestamp' 	=> "\t`{columnname}` TIMESTAMP {null} {default} {description},\n",
		'tinyblob' 		=> "\t`{columnname}` TINYBLOB {null} {description},\n",
		'tinyint' 		=> "\t`{columnname}` TINYINT {null} {description},\n",
		'tinytext' 		=> "\t`{columnname}` TINYTEXT {null} {description},\n",
		'varbinary' 	=> "\t`{columnname}` VARBINARY {description},\n",
		'varchar' 		=> "\t`{columnname}` VARCHAR ({size}) {null} {default} {description},\n",
		'year'			=> "\t`{columnname}` YEAR ({size}) {null} {default} {description},\n"
	);
	
	/**
	 * Define max length of any column type
	 * @access		protected
	 * @var			array
	 */
	protected $_columnMaxLength = array(
		'bigint' => 0,
		'binary' => 255,
		'bit' => 64,
		'blob' => 0,
		'bool' => 0,
		'char' => 0,
		'date' => 0,
		'datetime' => 0,
		'decimal' => 0,
		'double' => 0,
		//'enum' => 0,
		'float' => 0,
		'int' => 11,
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
		'varchar' => 255,
		'year' => 4
	); 
	
	/**
	 * Define the create table string
	 * @access		protected
	 * @var			string
	 */
	protected $_tableCreateString = "CREATE TABLE IF NOT EXISTS `{tablename}` ( \n";
	
	/**
	 * Define the string for foreing columns in setup queries
	 * @access		protected
	 * @var			string
	 */
	protected $_foreignKeyString = "";

	/**
	 * Define the string for primary keys in setup queries
	 * @access		protected
	 * @var			string
	 */
	protected $_primaryKeyString = "\tPRIMARY KEY (`{pk_columnname}`)\n";
	
	/**
	 * Define the table ending string
	 * @access		protected
	 * @var			string
	 */
	protected $_tableCloseString = ") ENGINE=INNODB; \n\n";

}
?>

