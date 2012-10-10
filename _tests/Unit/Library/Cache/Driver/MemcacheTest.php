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
	 * Key for executing this tests
	 *
	 * @var string Key for this tests
	 */
	private $_key = 'Spaf\\_tests\\Unit\\Library\\Cache\Driver\\MemcacheTest';

	/**
	 * Content for executing this tests
	 *
	 * @var string Content for this tests
	 */
	private $_value = 'TestContent';

	/**
	 * Test to store an object from \stdClass
	 *
	 * @var \stdClass Object to test the store
	 */
	private $_object = null;

	/**
	 * Lifetime 5 seconds is enough anyway
	 *
	 * @var integer Lifetime in seconds
	 */
	private $_lifetime = 5;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_memcache = \Spaf\Library\Cache\Manager::factory('memcache');
		$this->_memcache->connect('cache01');
	}

	/**
	 * Test adding a value
	 *
	 * @return void
	 */
	public function testAdd() {
		// check if key does not exists yet
		/*$current = $this->_memcache->get($this->_key);
		
		$this->assertFalse(
			$this->_memcache->get($this->_key)
		);
		
		
		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_key, $this->_value, $this->_lifetime)
		);*/
		
		$this->_memcache->add($this->_key, $this->_value, $this->_lifetime);
		echo $this->_memcache->get($this->_key);
		$this->_memcache->delete($this->_key);
		die();
		
		/*
		echo $this->_memcache->get($this->_key);
		die();
		/*$this->assertTrue(
			$this->_memcache->get($this->_key) === $this->_value
		);*/
		
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		// be sure memcache variable is deleted
		$this->_memcache->delete($this->_key);
		unset($this->_memcache);
	}

}

?>