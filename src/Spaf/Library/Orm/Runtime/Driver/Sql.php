<?php
/**
 * $Id$
 * Database base driver class
 *
 * @created 	Fri Jul 30 05:25:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Spaf\Library\Orm\Runtime
 * @namespace	\Spaf\Library\Orm\Runtime\Driver
 */
namespace Spaf\Library\Orm\Runtime\Driver;

/**
 * Spaf\Library\Orm\Runtime\Driver\Sql
 *
 * The base abstract driver classe.
 * Every concrete driver has to extend this class.
 * You have to implement some functionality 
 * to be compatible with this abstract class.
 *
 * @author 		Claudio Walser
 * @abstract
 */
abstract class Sql {

	/**
     * The SQL-resource.
     *
     * @var		resource
     */
	protected $_connection = null;

	/**
     * The selected db.
     *
     * @var		resource
     */
	protected $_db = null;

	/**
     * Resultset of the last executed query.
     *
     * @var		resource
     */
	protected $_result = null;

    /**
     * Implement a connect function in your driver.
	 * This should do a connection to the database server.
     *
	 * @abstract
	 * @param	array		Data Source Name
     */
	abstract public function connect($dsn);

    /**
     * Implement a escapeValue function in your driver.
	 * This should escape a value to sending it to the server.
     *
	 * @abstract
	 * @param	string		Value to escape
     */
	abstract public function escapeValue($value);

    /**
     * Implement a getConnection function in your driver.
	 * This should do return the data base connection.
     *
	 * @abstract
     */
	abstract public function getConnection();

    /**
     * Implement a executeQuery function in your driver.
	 * This should perform a given query.
     *
	 * @abstract
	 * @param	string		Query string
     */
	abstract public function executeQuery($query);

    /**
     * Implement a getResultArray function in your driver.
	 * This should return the result set of a executed query.
     *
	 * @abstract
     */
	abstract public function getResultArray();
	
	




	// NOT IMPLEMENTED NOW
	/**
	 * Begin Transaction
	 */
	abstract public function begin();
	/**
	 * Commit Transaction
	 */
	abstract public function commit();
	/**
	 * Rollback Transaction
	 */
	abstract public function rollback();
}

?>