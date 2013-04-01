<?php

/**
 * $ID$
 *
 * Spaf/tools/testCache.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tools;

/**
 * \Spaf\tools\TestCache
 *
 * Class to test the cache in php-fpm
 * on nginx
 *
 * @author Claudio Walser
 * @package Spaf\tools
 * @namespace Spaf\tools
 */
class TestCache {

	/**
	 * Run the caching test on nginx
	 *
	 * @return void
	 */
	public function __construct() {
		require_once('autoloader.php');
		$loader = new Autoloader(false);


		$cache = \Spaf\Library\Cache\Manager::factory('memcache');

		/**
		 * Memcache specific
		 */
		$cache->connect('cache01');

		$key = 'test2';
		$value = 'super3';
		$ttl = 200; // three seconds


		if ($cache->exists($key) === false) {
			echo 'now stored ';
			$cache->add($key, $value, $ttl);
		}

		var_dump($cache->get($key));



		$key2 = 'test';
		$value2 = 'super duper';
		$ttl2 = 3; // three seconds


		if ($cache->exists($key2) === false) {
			echo 'now stored ';
			$cache->add($key2, $value2, $ttl2);
		}

		var_dump($cache->get($key2));

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
$testCache = new TestCache();

?>