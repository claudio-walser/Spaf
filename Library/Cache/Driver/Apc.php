<?php

/**
 * $ID$
 *
 * Spaf/Library/Cache/Driver/Apc.php
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Cache\Driver;

/**
 * \Spaf\Library\Cache\Driver\Apc
 *
 * Concrete APC Cache Class.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Cache\Driver
 * @namespace Spaf\Library\Cache\Driver
 */
class Apc extends Abstraction {

	/**
	 * Constructs the APC cache.
	 * Constructor is throwing an Exception if no APC is installed
	 * locally.
	 *
	 * @return void
	 */
	public function __construct() {
		if (!function_exists('apc_add')) {
			throw new Exception('APC is not installed on this server.');
		}
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

		$return = apc_add($key, $value, $ttl);

		if ($return === false) {
			throw new Exception('Value with key ' . $key . ' already exists.');
		}

		return true;
	}

	/**
	 * Get a value by key
	 * Returns false if nothing found with this key
	 *
	 * @param string Key to fetch
	 * @return mixed Stored value or null if nothing found
	 */
	public function get($key) {
		$value = apc_fetch($key, $success);
		if ($success === false) {
			$value = null;
		}

		return $value;
	}

	/**
	 * Check if a variable exists by key
	 *
	 * @param string Key of the value
	 * @return boolean True or false wheter the cache-key exists or not
	 */
	public function exists($key) {
		$key = (string) $key;

		return apc_exists($key);
	}

	/**
	 * Remove a variable by key
	 *
	 * @param string Key of the value to delete
	 * @return boolean True if deletion was successful
	 */
	public function delete($key) {
		$key = (string) $key;
		// delete by key
		apc_delete($key);

		// return true if key does not exists anymore
		return !$this->exists($key);
	}

}