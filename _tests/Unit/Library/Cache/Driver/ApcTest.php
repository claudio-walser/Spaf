<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Cache/Driver/ApcTest.php
 * @created Wed Oct 10 18:57:56 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Cache\Driver;

/**
 * \Spaf\_tests\Unit\Library\Cache\ApcTest
 *
 * The ApcTest class tests any aspect of \Spaf\Library\Cache\Driver\Apc.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Cache\Driver
 * @namespace Spaf\_tests\Unit\Library\Cache\Driver
 */
class ApcTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Apc instance
	 *
	 * @var \Spaf\Library\Cache\Apc
	 */
	private $_apc = null;

	/**
	 * Key for executing this tests
	 *
	 * @var string Key for this tests
	 */
	private $_key = 'Spaf\\_tests\\Unit\\Library\\Cache\Driver\\ApcTestSack';

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
		$this->_apc = \Spaf\Library\Cache\Manager::factory('apc');
		$this->_object = new \stdClass();
	}

	/**
	 * Test adding a value
	 *
	 * @return void
	 */
	public function testAdd() {
		// check if key does not exists yet
		$this->assertFalse(
			$this->_apc->exists($this->_key)
		);

		// assert write to the store is true
		$this->assertTrue(
			$this->_apc->add($this->_key, $this->_value, $this->_lifetime)
		);

		// boy apc is crap
		/*//check lifetime with 1 second
		$this->_apc->delete($this->_key);
		$this->_apc->add($this->_key, $this->_value, 1);
		// sleep 1.2 seconds
		var_dump($this->_apc->get($this->_key));
		usleep(2000000);
		var_dump($this->_apc->get($this->_key));
		$this->assertFalse(
			$this->_apc->exists($this->_key)
		);*/
	}

	/*
	public function testGet() {
		// assert write to the store is true
		$this->assertEquals(
			$this->_value,
			$this->_apc->get($this->_key)
		);
	}

	public function testExists() {

	}

	public function testDelete() {

	}*/

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		// delete apc value on tear down for sure
		$this->_apc->delete($this->_key);
		unset($this->_apc);
	}

}

?>