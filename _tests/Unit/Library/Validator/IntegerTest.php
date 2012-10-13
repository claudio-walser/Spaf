<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/IntegerTest.php
 *
 * @create Sat Oct 13 21:39:52 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Validator;

/**
 * \Spaf\_tests\Unit\Library\Validator\IntegerTest
 *
 * The IntegerTest class tests any aspect of \Spaf\Library\Validator\Integer.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Validator
 * @namespace Spaf\_tests\Unit\Library\Validator
 */
class IntegerTest extends \PHPUnit_Framework_TestCase {

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
	private $_testValue = 10;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Integer($this->_testValue);
	}

	/**
	 * Test the Integer.
	 *
	 * @return void
	 */
	public function testSimple() {
		// test normal
		$this->assertTrue(
			$this->_validator->validate()
		);

		// test integer but passed as string
		$this->_validator->setValue((string) $this->_testValue);
		$this->assertTrue(
			$this->_validator->validate()
		);

		// test wrong value
		$this->_validator->setValue('10s');
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