<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/DateTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Validator;

/**
 * \Spaf\_tests\Unit\Library\Validator\DateTest
 *
 * The ArrayTest class tests any aspect of \Spaf\Library\Validator\Date.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Validator
 * @namespace Spaf\_tests\Unit\Library\Validator
 */
class DateTest extends \Spaf\_tests\Unit\TestCase {

	/**
	 * Validator instance
	 *
	 * @var \Spaf\Library\Validator\Date
	 */
	private $_validator = null;

	/**
	 * Testdate in german format
	 *
	 * @var string
	 */
	private $_testValue = '09.12.1979';

	/**
	 * Testdate in english format
	 *
	 * @var string
	 */
	private $_testValueUs = '1979-12-09';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Date($this->_testValue);
	}

	/**
	 * Test german format.
	 *
	 * @return void
	 */
	public function testGermanFormat() {
		// test something wrong first
		$wrongValue = '32.12.2012';
		$this->_validator->setValue($wrongValue);
		$this->_validator->setFormat('d.m.Y');

		$this->assertFalse(
			$this->_validator->validate()
		);


		// set value again, to be damn sure
		$this->_validator->setValue($this->_testValue);
		$this->_validator->setFormat('d.m.Y');

		$this->assertTrue(
			$this->_validator->validate()
		);
	}

	/**
	 * Test english format.
	 *
	 * @return void
	 */
	public function testEnglishFormat() {
		// test something wrong first
		$wrongValue = '2012-13-02';
		$this->_validator->setValue($wrongValue);
		$this->_validator->setFormat('Y-m-d');

		$this->assertFalse(
			$this->_validator->validate()
		);

		// set value again, to be damn sure
		$this->_validator->setValue($this->_testValueUs);
		$this->_validator->setFormat('Y-m-d');

		$this->assertTrue(
			$this->_validator->validate()
		);
	}

	/**
	 * Test set a new value during runtime
	 */
	public function testSetValue() {
		// set value to german date
		$this->_validator->setValue($this->_testValue);
		//assert
		$this->assertEquals(
			$this->_testValue,
			$this->_validator->getValue()
		);

		// change value to us date
		$this->_validator->setValue($this->_testValueUs);
		// assert
		$this->assertEquals(
			$this->_testValueUs,
			$this->_validator->getValue()
		);

	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_validator);
		unset($this->_testValue);
		unset($this->_testValueUs);
	}

}

?>