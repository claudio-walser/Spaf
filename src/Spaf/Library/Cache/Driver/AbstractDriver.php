<?php

/**
 * $ID$
 *
 * Spaf/Library/Cache/Driver/AbstractDriver.php
 * @created Wed Oct 10 20:58:52 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Cache\Driver;

/**
 * \Spaf\Library\Cache\Driver\AbstractDriver
 *
 * Abstract Cache Driver Class.
 * Any concrete driver has to extend
 * its abstract methods at least.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Cache\Driver
 * @namespace Spaf\Library\Cache\Driver
 */
abstract class AbstractDriver {

	/**
	 * Default cache lifetime in seconds.
	 * One hour by default.
	 *
	 * @var integer
	 */
	protected $_lifetime = 3600;

	/**
	 * Set default lifetime in seconds.
	 *
	 * @param integer New default lifetime in seconds
	 * @return boolean True
	 */
	public function setDefaultLifetime($lifetime) {
		$this->_lifetime = (int) $lifetime;

		return true;
	}

	/**
	 * Add a variable to the store.
	 *
	 * @param string Key for this value
	 * @param mixed Value itself
	 * @param integer Time to life, default to default lifetime.
	 * @return boolean True if it was able to save the value.
	 */
	abstract public function add($key, $value, $ttl = null);

	/**
	 * Check if a variable exists by passing
	 * its key
	 *
	 * @param string Key of the value
	 * @return boolean True or false wheter the cache-key exists or not
	 */
	abstract public function exists($key);

	/*abstract public function update($key, $value, $expire = 0, $flag = false);

	abstract public function remove($key);

	abstract public function fetch();

	abstract public function update();



	abstract public function debug();
	*/
}


/*

APC Funktionen

	apc_bin_dump — Get a binary dump of the given files and user variables
	apc_bin_dumpfile — Output a binary dump of cached files and user variables to a file
	apc_bin_load — Load a binary dump into the APC file/user cache
	apc_bin_loadfile — Load a binary dump from a file into the APC file/user cache
	apc_cache_info — Retrieves cached information from APC's data store
	apc_cas — Updates an old value with a new value
	apc_clear_cache — Clears the APC cache
	apc_compile_file — Speichert eine Datei im Bytecode Cache unter Umgehung aller Filter.
	apc_dec — Decrease a stored number
	apc_define_constants — Defines a set of constants for retrieval and mass-definition
	apc_delete_file — Deletes files from the opcode cache
	apc_delete — Removes a stored variable from the cache
	apc_exists — Checks if APC key exists
	apc_fetch — Fetch a stored variable from the cache
	apc_inc — Increase a stored number
	apc_load_constants — Loads a set of constants from the cache
	apc_sma_info — Retrieves APC's Shared Memory Allocation information
	apc_store — Cache a variable in the data store


Memcache — The Memcache class

	Memcache::add — Add an item to the server
	Memcache::addServer — Add a memcached server to connection pool
	Memcache::close — Close memcached server connection
	Memcache::connect — Open memcached server connection
	Memcache::decrement — Decrement item's value
	Memcache::delete — Delete item from the server
	Memcache::flush — Flush all existing items at the server
	Memcache::get — Retrieve item from the server
	Memcache::getExtendedStats — Get statistics from all servers in pool
	Memcache::getServerStatus — Returns server status
	Memcache::getStats — Get statistics of the server
	Memcache::getVersion — Return version of the server
	Memcache::increment — Increment item's value
	Memcache::pconnect — Open memcached server persistent connection
	Memcache::replace — Replace value of the existing item
	Memcache::set — Store data at the server
	Memcache::setCompressThreshold — Enable automatic compression of large values
	Memcache::setServerParams — Changes server parameters and status at runtime

Memcache Funktionen

	memcache_debug — Turn debug output on/off


 */
?>