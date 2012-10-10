<?php

/**
 * $Id$
 *
 * Spaf/Library/Cache/Driver/Memcache.php
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Cache\Driver;

/**
 * \Spaf\Library\Cache\Driver\Memcache
 *
 * Concrete APC Cache Class.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Cache\Driver
 * @namespace Spaf\Library\Cache\Driver
 */
class Memcache extends Abstraction {

	/**
	 * Array with all passed server informations.
	 * Such as Host, port, weight, timeout and so on.
	 *
	 * @var array
	 */
	private $_servers = array();
	
	/**
	 * \Memcache instance
	 * 
	 * @var \Memcache
	 */
	private $_memcache = null;
	 
	/**
	 * Note you HAVE to connect to one memcache
	 * server at least. If you dont call connect, 
	 * an exeption will be thrown by any further operation.
	 * 
	 * @param string Memcache Host
	 * @param integer Port where this host is listening
	 * @param integer Connection timeout in seconds. Think twice before changing the default value of 1 second - you can lose all the advantages of caching if your connection is too slow.
	 * @return boolean True if connection was successful, otherwise false
	 */
	public function connect($host, $port, $timeout = 1) {
		if ($this->_memcache !== null) {
			throw new Exception('You can only connect to one memcache master.');
		}
		
		$this->_memcache = memcache_connect($host, $port, $timeout);
		if ($this->_memcache === false) {
			$this->_memcache = null;
			throw new Exception('Could not connect to memcache server');
		}
	}
	
	/**
	 * Add one or more servers.
	 * See http://php.net/manual/en/memcache.addserver.php 
	 * for more details.
	 * 
	 * @param string Memcache Host
	 * @param integer Port where this host is listening
	 * @param boolean True for persistent server connection. Default to true
	 * @param integer Weight Number of buckets to create for this server which in turn control its probability of it being selected. The probability is relative to the total weight of all servers.
	 * @param integer Connection timeout in seconds. Think twice before changing the default value of 1 second - you can lose all the advantages of caching if your connection is too slow.
	 * @param integer Retry interval in seconds, default to 15
	 * @param boolean Default to true, meaning the server should be considered online.
	 * @param closure Failure Callback to react in case of connection failed.
	 * @return boolean True if connection was successful, otherwise false
	 */
	public function addServer($host, $port = 11211, $persistent = true, $weight = 1, $timeout = 1, $retry_interval = 15, $status = true, $failure_callback = null) {
		$this->_checkInstance();
	}
	
    /**
	 * Add a variable to the store.
	 *
	 * @param string Key for this value
	 * @param mixed Value itself
	 * @param integer Time to life, default to default lifetime.
	 * @return boolean True if it was able to save the value.
	 */
	public function add($key, $value, $ttl = null) {
		if ($ttl === null) {
			$ttl = $this->_lifetime;
		}

	}
	
	/**
	 * Check if memcache instance exists.
	 * 
	 * @throws \Spaf\Library\Cache\Driver\Exception Throws an exception if no memcache instance found yet
	 * @return boolean True
	 */
	private function _checkInstance() {
		if (!$this->_memcache instanceof \Memcache) {
			throw new Exception('You have to successful connect to a master server first. Call Memcache::connect()');
		}
		
		return true;
	}
	
}