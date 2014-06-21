<?php
/**
 * $Id$
 * Database connection manager class
 *
 * @created 	Fri Jul 30 05:25:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Spaf\Library\Database
 * @namespace	\Spaf\Library\Database
 */
namespace Spaf\Library\Orm\Runtime;

use Spaf\Library\Orm\Runtime\Driver\Mysql;
use Spaf\Library\Orm\Runtime\Driver\Mysqli;

/**
 * Spaf\Library\Orm\Runtime\Manager
 *
 * This class is the main database manager.
 * It stores different sql resources from a given data source name.
 *
 * @author 		Claudio Walser
 * @abstract
 */
abstract class Manager {

	/**
     * Driver objects.
	 * Defined by the factory.
     *
     * @var		array
     */
	private static $_connections = array();



    /**
     * Creates a database connection
     *
	 * In order of the given dsn, a concrete driver object will
	 * be created.
     *
     * @todo 	create a DataSourceName class instead of the array
	 * @param	array		Data Source Name
	 * @return	\Spaf\Library\Orm\Runtime\Driver\Sql
     */
	public static function getConnection($dsn) {
		// still no type hinting with arrays :(
		if (!is_array($dsn)) {
			throw new Exception('Database\\Manager::getConnection -- FatalError: first param has to be a array, ' . gettype($dsn) . ' given!');
		}

		// connect with the given params if not done yet
		if (!isset(self::$_connections[$dsn['dbdriver'] . '_' . $dsn['database']])) {
			switch (strtolower($dsn['dbdriver'])) {
				case 'mysql':
					self::$_connections[$dsn['dbdriver'] . '_' . $dsn['database']] = new Mysql($dsn);
					break;

				case 'mysqli':
					self::$_connections[$dsn['dbdriver'] . '_' . $dsn['database']] = new Mysqli($dsn);
					break;

				default:
					throw new Exception('Can\'t find any driver for ' . $dsn['dbdriver']);
					break;

			}
			self::$_connections[$dsn['dbdriver'] . '_' . $dsn['database']]->connect($dsn);
		}

		// return connection
		return 	self::$_connections[$dsn['dbdriver'] . '_' .$dsn['database']];
	}

}

?>