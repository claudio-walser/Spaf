<?php

/**
 * $ID$
 *
 * Spaf/Library/cache.php
 * @author Claudio Walser
 * @created Wed Oct 03 11:02:06 +0200 2012
 */

namespace Spaf\Library\Cache;

/**
 * Abstract 
 */
abstract class Abstraction {
    
    /**
     * Default cache type. Possible values are
     * memcache || apc
     * 
     * @var string
     */
    private static $_cacheType = 'memcache';
    
    private static $_allowedCacheTypes = array('apc', 'memcache');
    
    /**
     * Factory instances
     * 
     * @var array Array with Spaf\Library\Cache\Abstraction Objects
     */
    private static $_instances = array();
    
    public static function factory($cacheType = 'memcache') {
        
        $cacheType = strtolower($cacheType);
        
        if (!in_array($cacheType, self::$_allowedCacheTypes)) {
            $cacheType = self::$_cacheType;
        }
        
        if (!isset(self::$_instances[$cacheType]) || !self::$_instances[$cacheType] instanceof \Spaf\Library\Cache\Abstraction) {
            switch ($cacheType) {
                case 'apc':
                    self::$_instances['apc'] = new Apc();
                    break;
                default:
                    self::$_instances['memcache'] = new Memcache();
                    break;
            }
        }
    }
    
    abstract public function store($key, $value, $expire = 0, $flag = false);
    
    abstract public function overwrite($key, $value, $expire = 0, $flag = false);
    
    abstract public function remove($key);
    
    abstract public function fetch();
    
    abstract public function update();
    
    abstract public function exists();
    
    abstract public function debug();
    
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