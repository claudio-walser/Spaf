<?php

/**
 * $ID$
 *
 * Spaf/Library/Cache/Driver/Apc.php
 * @author Claudio Walser
 * @created Wed Oct 10 18:57:56 +0200 2012
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
		
		return apc_add($key, $value, $ttl);
	}

}