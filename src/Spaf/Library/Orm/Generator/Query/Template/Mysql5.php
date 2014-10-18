<?php
namespace Spaf\Library\Orm\Generator\Query\Template;

/**
 * UdaMysql5Template.php :: Final class for mysql5 template
 *
 * This is the final mysql5 template class.
 * The only different is the foreign key string because foreign columns can be defined in mysql5.
 *
 * @final
 * @category	SqlTemplate
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */ 
final class Mysql5 extends Mysql {

	/**
	 * Define the string for foreing columns in setup queries
	 * @access		protected
	 * @var			string
	 */
	protected $_foreignKeyString = "\tCONSTRAINT `{constraint}` FOREIGN KEY (`{foreignKey}`) REFERENCES `{foreignTable}` (`{foreignPrimaryKey}`),\n";
}
?>

