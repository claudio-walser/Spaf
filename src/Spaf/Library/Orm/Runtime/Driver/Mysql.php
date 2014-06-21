<?php
/**
 * $Id$
 * Concrete MySQL driver
 * Test description in order to test that crap
 *
 * @created 	Fri Jul 30 05:35:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Spaf\Library\Orm\Runtime
 * @namespace	\Spaf\Library\Orm\Runtime\Driver
 */
namespace Spaf\Library\Orm\Runtime\Driver;


/**
 * Spaf\Library\Orm\Runtime\Driver\Mysql
 *
 * The concrete driver for the mysql extension.
 * This driver class handles queries over the mysql
 * extension.
 *
 * @author 		Claudio Walser
 */
class Mysql extends Sql {

    /**
     * Do a connection
	 * This method connect to a given database server
	 * with the native mysql extension.
     *
	 * @param	array		Data Source Name
	 * @return boolean
     */
	public function connect($dsn) {
		// get connection
		$this->_connection = mysql_connect($dsn['hostname'] . ':' . $dsn['port'], $dsn['username'], $dsn['password']);
		if ($this->_connection === false) {
			throw new Exception('MySQL FatalError: can\'t connect to ' . $dsn['hostname'] . ', login failed!');
		}
		// select db
		$this->_db = mysql_select_db($dsn['database'], $this->_connection);
		if ($this->_db === false) {
			throw new Exception('MySQL FatalError: can\'t find database ' . $dsn['database'] . '!');
		}

		return true;
	}

    /**
     * Escape a value
	 * This method escape a value in order to sending it
	 * to the database server.
     *
	 * @param	string		Value to escape
	 * @return	string		Escaped string, ready for an insert
     */
	public function escapeValue($value) {
		return mysql_real_escape_string($value);
	}

    /**
     * Get the connection
	 * This method returns the connection object.
     *
	 * @return	Mysql		The mysql object
     */
	public function getConnection() {
		return $this->_connection;
	}

    /**
     * Execute a query
	 * This method executes a given query
	 * and stores it's result.
     *
	 * @param	string		Query to execute
	 * @return	boolean
     */
	public function executeQuery($query) {
		$this->_result = mysql_query($query);
		if (mysql_error()) {
			$this->_result = null;
			throw new Exception('MySQL FatalError: ' . mysql_error() . "\nQuery was: " . $query . "\n" . '!');
			return false;
		}
		return true;
	}

    /**
     * Get the result set
	 * This method returns the results set 
	 * from the last executed query.
     *
	 * @return	array		Result set of the last query
     */
	public function getResultArray() {
		$result = array();
		while($row = mysql_fetch_assoc($this->_result)) {
			array_push($result, $row);
		}
		if (empty($result)) {
			$result = null;
		}
		return $result;
	}

    /**
     * Return a limit statement
	 * This method returns a limit statement.
	 * Use always this method, because
	 * on different dbms, limit statements
	 * are also different.
     *
	 * @param	int		How many records to limit
	 * @param	int		Optional: Where to start
	 * @return	string	The limit condition
     */
	public static function getLimit($limit, $offset = null) {
		return $offset === null ? ' LIMIT ' . $limit : ' LIMIT ' . $limit . ' OFFSET ' . $offset;
	}

    /**
     * Return the last auto increment value
	 * This method returns the last insert id.
	 * Use always this method, because
	 * on different dbms, limit statements
	 * are also different.
     *
	 * @return	int		The last insert id
     */
	public function getAutoIncrementValue() {
		return mysql_insert_id($this->_connection);
	}
	
	




	// NOT IMPLEMENTED NOW
	/**
	 * @see		DbDriver::begin
	 */
	public function begin() {
		// start transaction
	}
	/**
	 * @see		DbDriver::commit
	 */
	public function commit() {
		// commit transaction
	}
	/**
	 * @see		DbDriver::rollback
	 */
	public function rollback() {
		// rollback transaction
	}
}

?>