<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/IpTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Validator;

/**
 * \Spaf\_tests\Unit\Library\Validator\IpTest
 *
 * The IpTest class tests any aspect of \Spaf\Library\Validator\Ip.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Validator
 * @namespace Spaf\_tests\Unit\Library\Validator
 */
class IpTest extends \Spaf\_tests\Unit\TestCase {

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
	private $_testValue = '10.20.0.100';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Ip($this->_testValue);
	}

	/**
	 * Test the ip.
	 *
	 * @return void
	 */
	public function testSimple() {
		// test normal
		$this->assertTrue(
			$this->_validator->validate()
		);

		// test wrong value
		$this->_validator->setValue('256.20.0.100');
		$this->assertFalse(
			$this->_validator->validate()
		);

		// test with wildcards
		$this->_validator->setValue('10.20.0.*');
		$this->_validator->useWildcards(true);
		$this->assertTrue(
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