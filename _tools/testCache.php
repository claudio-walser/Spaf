<?php

/**
 * $ID$
 *
 * Spaf/_tools/testCache.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tools;

/**
 * \Spaf\_tools\TestCache
 *
 * Class to test the cache in php-fpm
 * on nginx
 *
 * @author Claudio Walser
 * @package Spaf\_tools
 * @namespace Spaf\_tools
 */
class TestCache {

	/**
	 * Run the caching test on nginx
	 *
	 * @return void
	 */
	public function __construct() {
		$cache = \Spaf\Library\Cache\Manager::factory('memcache');

		/**
		 * Memcache specific
		 */
		$cache->connect('cache01');

		$key = 'test2';
		$value = 'super3';
		$ttl = 20; // three seconds


		if ($cache->exists($key) === false) {
			echo 'stored ';
			$cache->add($key, $value, $ttl);
		}
		var_dump($cache->get($key));
		/*
		 * tests with sleep, memcache might work since its an external server
		 * But this thing is ignoring my given lifetime anyway so no tests yet
		sleep(6);

		if ($cache->exists($key) === false) {
			echo 'stored ';
			$cache->add($key, $value, $ttl);
		}

		var_dump($cache->get($key));*/
	}

}

// run
$testCache = new \Spaf\_tools\TestCache();

?>