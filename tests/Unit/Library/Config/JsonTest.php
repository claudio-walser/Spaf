<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Config/JsonTest.php
 * @created Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Config;

/**
 * \Spaf\tests\Unit\Library\Config\JsonTest
 *
 * The JsonTest class tests any aspect of \Spaf\Library\Config\Driver\Json.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Config
 * @namespace Spaf\tests\Unit\Library\Config
 */
class JsonTest extends AbstractConfig {

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
		parent::setUp();
	}


	/**
	 * Test just call the parant one, cause they are the same for all drivers
	 */

	/**
	 * Test read a value
	 *
	 * @see \Spaf\tests\Unit\Library\Config\AbstractConfig::readValue()
	 * @return void
	 */
	public function testReadValue() {
		parent::readValue();
	}

	/**
	 * Test change a value
	 *
	 * @see \Spaf\tests\Unit\Library\Config\AbstractConfig::changeValue()
	 * @return void
	 */
	public function testChangeValue() {
		parent::changeValue();
	}

	/**
	 * Test set a new value in an existent section
	 *
	 * @see \Spaf\tests\Unit\Library\Config\AbstractConfig::setValueInExistentSection()
	 * @return void
	 */
	public function testSetValueInExistentSection() {
		parent::setValueInExistentSection();
	}

	/**
	 * Test set a new value in a new section
	 *
	 * @see \Spaf\tests\Unit\Library\Config\AbstractConfig::setValueInNewSection()
	 * @return void
	 */
	public function testSetValueInNewSection() {
		parent::setValueInNewSection();
	}

	/**
	 * Test set a new value in a new section and save
	 * everything as a new config file.
	 * Then create a new config manager object with this file
	 * and compare its content.
	 *
	 * @see \Spaf\tests\Unit\Library\Config\AbstractConfig::save()
	 * @return void
	 */
	public function testSave() {
		parent::save();
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	protected function tearDown() {
		parent::tearDown();
	}

}

?>