<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Cache/Driver/MemcacheTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Cache\Driver;

/**
 * \Spaf\tests\Unit\Library\Cache\Driver\MemcacheTest
 *
 * The MemcacheTest class tests any aspect of \Spaf\Library\Cache\Driver\Memcache.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Cache\Driver
 * @namespace Spaf\tests\Unit\Library\Cache\Driver
 */
class MemcacheTest extends \Spaf\tests\Unit\TestCase {

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
	private $_key = 'Spaf\\tests\\Unit\\Library\\Cache\Driver\\MemcacheTest';

	/**
	 * Content for executing this tests
	 *
	 * @var string Content for this tests
	 */
	private $_value = 'TestContent';

	/**
	 * Key for executing this tests
	 *
	 * @var string Key for this tests
	 */
	private $_objectKey = 'Spaf\\tests\\Unit\\Library\\Cache\Driver\\MemcacheTestObject';

	/**
	 * Test to store an object from \stdClass
	 *
	 * @var \stdClass Object to test the store
	 */
	private $_object = null;

	/**
	 * Lifetime 1 second is enough for tests anyway
	 *
	 * @var integer Lifetime in seconds
	 */
	private $_lifetime = 1;

	/**
	 * Memcache host one
	 *
	 * @var string cache hostname
	 */
	private $_host = 'cache01';

	/**
	 * Memcache host two
	 *
	 * @var string cache hostname
	 */
	private $_secondHost = 'cache02';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_memcache = \Spaf\Library\Cache\Manager::factory('memcache');
		$this->_memcache->connect($this->_host);

		$this->_object = new \stdClass();
		$this->_object->name = $this->_value;
	}

	/**
	 * Test adding a string
	 *
	 * @return void
	 */
	public function testAddString() {
		// assert nothing stored yet
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);

		// assert exists equals false
		$this->assertFalse(
			$this->_memcache->exists($this->_key)
		);

		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_key, $this->_value, $this->_lifetime)
		);

		// assert exists equals true
		$this->assertTrue(
			$this->_memcache->exists($this->_key)
		);

		// test value and memcache value has to be the same
		$this->assertEquals(
			$this->_value,
			$this->_memcache->get($this->_key)
		);

		// wait for lifetime plus ten microseconds
		usleep($this->_lifetime * 1000000 + 10);
		// assert its purged now
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);
	}

	/**
	 * Test adding an object
	 *
	 * @return void
	 */
	public function testAddObject() {
		// assert nothing stored yet
		$this->assertNull(
			$this->_memcache->get($this->_objectKey)
		);

		// assert exists equals false
		$this->assertFalse(
			$this->_memcache->exists($this->_objectKey)
		);

		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_objectKey, $this->_object, $this->_lifetime)
		);

		// assert exists equals true
		$this->assertTrue(
			$this->_memcache->exists($this->_objectKey)
		);

		// test value and memcache value has to be the same
		$this->assertEquals(
			$this->_object,
			$this->_memcache->get($this->_objectKey)
		);

		// wait for lifetime plus ten microseconds
		usleep($this->_lifetime * 1000000 + 10);
		// assert its purged now
		$this->assertNull(
			$this->_memcache->get($this->_objectKey)
		);
	}

	/**
	 * Test delete a value
	 *
	 * @return void
	 */
	public function testDelete() {
		// assert nothing stored yet
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);

		// assert delete is false yet
		$this->assertFalse(
			$this->_memcache->delete($this->_key)
		);

		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_key, $this->_value, $this->_lifetime)
		);

		// test value and memcache value has to be the same
		$this->assertEquals(
			$this->_value,
			$this->_memcache->get($this->_key)
		);

		// assert delete is true
		$this->assertTrue(
			$this->_memcache->delete($this->_key)
		);

		// assert nothing stored after delete
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);
	}

	/**
	 * Test clear all
	 *
	 * @return void
	 */
	public function testClear() {
		// assert nothing stored yet
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);
		$this->assertNull(
			$this->_memcache->get($this->_objectKey)
		);


		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_key, $this->_value, $this->_lifetime)
		);
		$this->assertTrue(
			$this->_memcache->add($this->_objectKey, $this->_object, $this->_lifetime)
		);


		// test value and memcache value has to be the same
		$this->assertEquals(
			$this->_value,
			$this->_memcache->get($this->_key)
		);
		$this->assertEquals(
			$this->_object,
			$this->_memcache->get($this->_objectKey)
		);


		// assert delete is true
		$this->assertTrue(
			$this->_memcache->flush($this->_key)
		);


		// assert nothing stored after delete
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);
		$this->assertNull(
			$this->_memcache->get($this->_objectKey)
		);
	}

	/**
	 * Test clear all
	 *
	 * @return void
	 */
	public function testAddServer() {

		// assert true adding the second server to the first memcache instance
		$this->assertTrue(
			$this->_memcache->addServer($this->_secondHost)
		);
	}

	/**
	 * Test overwrite something to early
	 *
	 * @return void
	 */
	public function testOverwriteToEarly() {
		// assert nothing stored yet
		$this->assertNull(
			$this->_memcache->get($this->_key)
		);

		// assert write to the store is true
		$this->assertTrue(
			$this->_memcache->add($this->_key, $this->_value, $this->_lifetime)
		);

		// assert exception to be expect
		$this->setExpectedException('\\Spaf\\Library\\Cache\\Driver\\Exception');
		$this->_memcache->add($this->_key, $this->_value, $this->_lifetime);
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