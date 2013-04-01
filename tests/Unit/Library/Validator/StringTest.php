<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Validator/StringTest.php
 * @create Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Validator;

/**
 * \Spaf\tests\Unit\Library\Validator\StringTest
 *
 * The StringTest class tests any aspect of \Spaf\Library\Validator\String.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Validator
 * @namespace Spaf\tests\Unit\Library\Validator
 */
class StringTest extends \Spaf\tests\Unit\TestCase {

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
	private $_testValue = 'Test mit 20 Zeichen.';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\String($this->_testValue);
	}

	/**
	 * Test min length.
	 *
	 * @return void
	 */
	public function testSetMinLength() {
		$this->_validator->setMinLength(20);
		$this->assertTrue(
			$this->_validator->validate()
		);

		// test wrong value
		$this->_validator->setMinLength(21);
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Test max length.
	 *
	 * @return void
	 */
	public function testSetMaxLength() {
		$this->_validator->setMaxLength(20);
		$this->assertTrue(
			$this->_validator->validate()
		);

		// test wrong value
		$this->_validator->setMaxLength(19);
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_testValue);
		unset($this->_validator);
	}

}

?>