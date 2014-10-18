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
class Config {

	/**
	 * DB Host
	 * @access		private
	 * @var			string
	 */
	private $_host = '';

	/**
	 * DB Port
	 * @access		private
	 * @var			int
	 */
	private $_port = '';
	
	/**
	 * DB User
	 * @access		private
	 * @var			string
	 */
	private $_user = '';

	/**
	 * DB Pass
	 * @access		private
	 * @var			string
	 */
	private $_pass = '';

	/**
	 * Description of this table
	 * @access		private
	 * @var			string
	 */
	private $_name = '';
	
	private $_sqlDriver = null;
	
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
	public function setHost($host) {
		$this->_host = $host;
		return true;
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
	public function getHost() {
		return $this->_host;
	}
	
	/**
	 * set port number
	 *
	 * Set the db port number
	 *
	 * Get the name of this table.
	 *
	 * @param		int			Port number
	 * @return		boolean
	 * @access		public
	 */
	public function setPort($port) {
		$this->_port = $port;
		return true;
	}
	
	/**
	 * get port number
	 *
	 * Return the db port number
	 *
	 * @return		int			Port number
	 * @access		public
	 */
	public function getPort() {
		return $this->_port;
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
	public function setUser($user) {
		$this->_user = $user;
		return true;
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
	public function getUser() {
		return $this->_user;
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
	public function setPass($pass) {
		$this->_pass = $pass;
		return true;
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
	public function getPass() {
		return $this->_pass;
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
	public function setName($name) {
		$this->_name = $name;
		return true;
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
	
	
	public function setSqlDriver($driver) {
		$this->_sqlDriver = $driver;
	}
	
	public function getSqlDriver() {
		return $this->_sqlDriver;
	}
}

?>