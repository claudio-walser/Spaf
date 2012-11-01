<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Config/ConversionTest.php
 * @created Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Config;

/**
 * \Spaf\_tests\Unit\Library\Config\ConversionTest
 *
 * The ConversionTest class tests any aspect of \Spaf\Library\Config\Driver\ Conversions.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Config
 * @namespace Spaf\_tests\Unit\Library\Config
 */
class ConversionTest extends \Spaf\_tests\Unit\TestCase {

	/**
	 * Driver to call
	 */
	protected $_driver = 'json';

	/**
	 * Filename for this config driver test
	 */
	protected $_filename = 'config.json';

	/**
	 * Filename of the copy for this config driver test
	 */
	protected $_filenameCopy = 'config-copy.json';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
	}

	/**
	 * Test read a value
	 *
	 * @see \Spaf\_tests\Unit\Library\Config\Abstraction::readValue()
	 * @return void
	 */
	public function testSomething() {
		$this->markTestIncomplete(
		  'Have to test all the conversions.'
		);
	}

}

?>