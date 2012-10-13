<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Validator/EmailTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Validator;

/**
 * \Spaf\_tests\Unit\Library\Validator\EmailTest
 *
 * The ArrayTest class tests any aspect of \Spaf\Library\Validator\Email.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Validator
 * @namespace Spaf\_tests\Unit\Library\Validator
 */
class EmailTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Validator instance
	 *
	 * @var \Spaf\Library\Validator\Array
	 */
	private $_validator = null;

	/**
	 * TestEmail in german format
	 *
	 * @var string
	 */
	private $_testValue = 'info@uwd.ch';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Email($this->_testValue);
	}

	/**
	 * Test simple and fast email validation
	 *
	 * @return void
	 */
	public function testSimple() {
		// needs an internet connection during the tests
		$this->_validator->useMxValidation(true);
		$this->_validator->setTopLevelDomains(array('de', 'ch'));

		$this->assertTrue(
			$this->_validator->validate()
		);
	}

	/**
	 * Test with tld limitation
	 *
	 * @return void
	 */
	public function testTopLevelDomain() {
		// true for de and ch
		$this->_validator->setTopLevelDomains(array('de', 'ch'));
		$this->assertTrue(
			$this->_validator->validate()
		);

		// false for only de
		$this->_validator->setTopLevelDomains(array('de'));
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Test with mx validation
	 * Needs some time cause of the dns request
	 * over network.
	 * Fails without established network connection
	 *
	 * @return void
	 */
	public function testMxValidation() {
		// needs an internet connection during the tests
		$this->_validator->useMxValidation(true);
		// should be truu, on the given address the mx is mail.uwd.ch
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
		unset($this->_validator);
		unset($this->_testValue);
	}

}

?>