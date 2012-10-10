<?php

/**
 * $Id$
 *
 * Spaf/_tests/Core/RegistryTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Core;

/**
 * \Spaf\_tests\Core\RegistryTest
 *
 * The RegistryTest class tests any aspect of \Spaf\Core\Registry.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Core
 * @namespace Spaf\_tests\Core
 */
class RegistryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The normal registry object
	 *
	 * @var \Spaf\Core\Registry
	 */
	private $_registry = null;

	/**
	 * The registry mock-object
	 *
	 * @var \Spaf\_tests\Mock\Core\Registry
	 */
	private $_mockObject = null;

	/**
	 * Setup both, normal and mock registry objects
	 *
	 * @return void
	 */
	protected function setUp() {
		// get normal registry first
		$this->_registry = \Spaf\Core\Registry::getInstance();
		// create the mockObject direct
		$this->_mockObject = \Spaf\_tests\Mock\Core\Registry::getInstance();
	}

	/**
	 * Test getInstance intense.
	 * Means test it by normal registry object and test
	 * mock-object injection as well.
	 *
	 * @return void
	 */
	public function testGetInstance() {
		// assert registry singleton
		$this->assertEquals(
			$this->_registry,
			\Spaf\Core\Registry::getInstance()
		);

		// assert registry mockable
		$this->assertEquals(
			$this->_mockObject,
			\Spaf\Core\Registry::getInstance($this->_mockObject)
		);

		// inject normal registry again, since getInstance is storing the current one in self::$_instance
		\Spaf\Core\Registry::getInstance($this->_registry);
	}

	/**
	 * Test set and get on simple object
	 * without persistence
	 *
	 * @return void
	 */
	public function testSetGet() {
		$assert = new \stdClass();
		$assert->name = 'assert';

		// setup registry first
		$this->_registry->set('assert', $assert);

		// check values
		$this->assertEquals(
			$this->_registry->get('assert'),
			$assert
		);

		unset($assert);
	}


	/**
	 * Test set and get on simple object
	 * with persistence. Set object persistent first,
	 * try to overwrite it with a different object,
	 * then get and do assertion on the first, persistent object.
	 *
	 * @return void
	 */
	public function testSetGetPersistent() {
		// object one
		$assert = new \stdClass();
		$assert->name = 'assert';
		// object two
		$assertPersistent = new \stdClass();
		$assertPersistent->name = 'assertPersistent';

		// set persistent
		$this->_registry->set('assertPersistent', $assertPersistent, true);

		// try overwrite
		try {
			$this->_registry->set('assertPersistent', $assert);
			$this->_registry->set('assertPersistent', $assert, true);
		} catch (\Spaf\Core\Exception $e) {
			// exception has its own test below
		}

		// check value
		$this->assertEquals(
			$this->_registry->get('assertPersistent'),
			$assertPersistent
		);

		unset($assert);
		unset($assertPersistent);
	}

	/**
	 * The Registry class is supposed to throw an exception if
	 * you try to store anything but an object
	 * This test is checking to be thrown.
	 *
	 * @return void
	 */
	public function testExceptionNotAnObject() {
		$this->setExpectedException('\Spaf\Core\Exception');
		// passing anything but an object has to throw an exception
		$this->_registry->set('assertPersistent', 'not an object');
	}

	/**
	 * The Registry class is supposed to throw an exception if
	 * you try to overwrite a persistent value
	 * This test is checking to be thrown.
	 *
	 * @return void
	 */
	public function testExceptionOverwritePersistent() {
		$this->setExpectedException('\Spaf\Core\Exception');

		// persistent overwrite
		$assertPersistent = new \stdClass();

		// store persistent
		$this->_registry->set('assertPersistent', $assertPersistent, true);
		// try to overwrite has to throw an exception
		$this->_registry->set('assertPersistent', $assertPersistent, true);

		unset($assertPersistent);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_registry);
		unset($this->_mockObject);
	}

}

?>