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
 * The ArrayTest class tests any aspect of \Spaf\Library\Validator\Array.
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
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$testArray = array(
			'one',
			'two',
			'three'
		);

		$this->_validator = new \Spaf\Library\Validator\Arrays($testArray);

		unset($directory);
		unset($directories);
	}

	/**
	 * Test getName.
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
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_directory);
		unset($this->_testName);
		unset($this->_testPath);
	}

}

?>