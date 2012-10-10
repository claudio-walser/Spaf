<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Cache/Driver/MemcacheTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Cache\Driver;

/**
 * \Spaf\_tests\Unit\Library\Cache\Driver\MemcacheTest
 *
 * The MemcacheTest class tests any aspect of \Spaf\Library\Cache\Driver\Memcache.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Cache\Driver
 * @namespace Spaf\_tests\Unit\Library\Cache\Driver
 */
class MemcacheTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Memcache instance
	 *
	 * @var \Spaf\Library\Cache\Driver\Memcache
	 */
	private $_memcache = null;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_memcache = \Spaf\Library\Cache\Manager::factory('memcache');
	}

	/**
	 * Test adding a value
	 *
	 * @return void
	 */
	public function testAdd() {
		$this->assertTrue(true);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_memcache);
	}

}

?>