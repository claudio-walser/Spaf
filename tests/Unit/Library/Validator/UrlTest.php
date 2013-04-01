<?php

/**
 * $ID$
 *
 * .php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Validator/UrlTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Validator;

/**
 * \Spaf\tests\Unit\Library\Validator\UrlTest
 *
 * The ArrayTest class tests any aspect of \Spaf\Library\Validator\Url.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Validator
 * @namespace Spaf\tests\Unit\Library\Validator
 */
class UrlTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Validator instance
	 *
	 * @var \Spaf\Library\Validator\Url
	 */
	private $_validator = null;

	/**
	 * TestUrl
	 *
	 * @var string
	 */
	private $_testValue = 'uwd.ch';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_validator = new \Spaf\Library\Validator\Url($this->_testValue);
	}

	/**
	 * Test simple and fast Url validation
	 *
	 * @return void
	 */
	public function testSimple() {
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
	 * Test with dns validation
	 * Needs some time cause of the dns request
	 * over network.
	 * Fails without established network connection
	 *
	 * @return void
	 */
	public function testDnsValidation() {
		// needs an internet connection during the tests
		$this->_validator->useDnsValidation(true);
		// should be true, on the given address since its reachable over the net
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