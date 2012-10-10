<?php

/**
 * $Id$
 *
 * Spaf/Library/Cache/Manager.php
 * @created Wed Oct 03 11:02:06 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Cache;

/**
 * \Spaf\Library\Cache\Manager
 *
 * The cache manager class is simply
 * handling the cache instances itself
 * and give you a unique interface to get each of them.
 * Default cache type is memcache, if you dont ask
 * the factory for something else.
 * Think about, each cache instance can offer you additional methods.
 * Like memcache provides an addServer method where apc doesnt.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Cache
 * @namespace Spaf\Library\Cache
 */
abstract class Manager {

    /**
     * Default cache type. Possible values are
     * memcache | apc
     *
     * @var string
     */
    private static $_defaultCacheType = 'memcache';

	/**
	 * All allowed cache types.
	 */
    private static $_allowedCacheTypes = array('apc', 'memcache');

    /**
     * Factory instances
     *
     * @var array Array with Spaf\Library\Cache\Abstraction Objects
     */
    private static $_instances = array();

	/**
	 * Get all allowed cache types
	 * you can pass to the factory method.
	 *
	 * @return array All cache types
	 */
	public static function getAllowedCacheTypes() {
		return self::$_allowedCacheTypes;
	}

	/**
	 * Factory method itself is creating exactly one instance
	 * per type. That means you cannot have two
	 * different instances of the same type.
	 * I'll see if this really is usefull, if not,
	 * i have to pimp this a bit.
	 */
    public static function factory($cacheType = 'memcache') {
        // always lower case
        $cacheType = strtolower($cacheType);
        // check if allowed type
        if (!in_array($cacheType, self::$_allowedCacheTypes)) {
            $cacheType = self::$_defaultCacheType;
        }

		// check and if needed, create instance
        if (!isset(self::$_instances[$cacheType]) || !self::$_instances[$cacheType] instanceof \Spaf\Library\Cache\Abstraction) {
            switch ($cacheType) {
                case 'apc':
                    self::$_instances[$cacheType] = new Apc();
                    break;
                default:
                    self::$_instances[$cacheType] = new Memcache();
                    break;
            }
        }

		// return instance
		return self::$_instances[$cacheType];
    }

}

?>