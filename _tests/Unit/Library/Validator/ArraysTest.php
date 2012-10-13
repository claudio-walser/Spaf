<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/ArraysTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Validator;

/**
 * \Spaf\_tests\Unit\Library\Validator\ArraysTest
 *
 * The ArraysTest class tests any aspect of \Spaf\Library\Validator\Arrays.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Validator
 * @namespace Spaf\_tests\Unit\Library\Validator
 */
class ArraysTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator instance
	 *
	 * @var \Spaf\Library\Validator\Array
	 */
	private $_validator = null;

	/**
	 * Array to run the tests with
	 *
	 * @var array
	 */
	private $_testArray = array(
		'one',
		'two',
		'three'
	);

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Arrays($this->_testArray);
	}

	/**
	 * Test minLength.
	 *
	 * @return void
	 */
	public function testMinLength() {
		$this->_validator->setMinLength(3);
		$this->assertTrue(
			$this->_validator->validate()
		);

		$this->_validator->setMinLength(4);
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Test minLength.
	 *
	 * @return void
	 */
	public function testMaxLength() {
		$this->_validator->setMaxLength(3);
		$this->assertTrue(
			$this->_validator->validate()
		);

		$this->_validator->setMaxLength(2);
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Test set a new value during runtime
	 */
	public function testSetValue() {
		$newTestArray = array(
			'one',
			'two'
		);

		$this->assertEquals(
			$this->_testArray,
			$this->_validator->getValue()
		);

		$this->_validator->setValue($newTestArray);

		$this->assertEquals(
			$newTestArray,
			$this->_validator->getValue()
		);

		unset($newTestArray);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_testArray);
		unset($this->_validator);
	}

}

?>