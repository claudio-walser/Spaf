<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Validator/FileTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Validator;

/**
 * \Spaf\tests\Unit\Library\Validator\FileTest
 *
 * The FileTest class tests any aspect of \Spaf\Library\Validator\File.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Validator
 * @namespace Spaf\tests\Unit\Library\Validator
 */
class FileTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Validator instance
	 *
	 * @var \Spaf\Library\Validator\Array
	 */
	private $_validator = null;

	/**
	 * Testvalue, we go to build a valid file path in the setUp method
	 *
	 * @var string
	 */
	private $_testValue = '';

	/**
	 * Name of the Testfile
	 *
	 * @var array
	 */
	private $_testName = 'php.gif';

	/**
	 * Expected size in bytes of the testfile
	 *
	 * @var int
	 */
	private $_expectedBytes = 2523;

	/**
	 * Expected md5 hash of the testfile
	 *
	 * @var int
	 */
	private $_expectedHash = '614fcbba1effb7caa27ef0ef25c27fcf';

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$directory = __DIR__;

		$directories = explode(DIRECTORY_SEPARATOR, $directory);
		array_pop($directories);
		array_pop($directories);
		array_pop($directories);

		array_push($directories, 'Data');
		array_push($directories, 'Validator');

		$this->_testPath = implode(DIRECTORY_SEPARATOR, $directories) . '/';
		$this->_testValue = $this->_testPath . $this->_testName;

		$this->_file = new \Spaf\Library\Directory\File($this->_testValue);

		$this->_validator = new \Spaf\Library\Validator\File($this->_testValue);

	}

	/**
	 * Test file size validation.
	 *
	 * @return void
	 */
	public function testSize() {
		$this->_validator->setMaxSize($this->_expectedBytes);
		// test normal
		$this->assertTrue(
			$this->_validator->validate()
		);

		$this->_validator->setMaxSize($this->_expectedBytes - 1);
		// test normal
		$this->assertFalse(
			$this->_validator->validate()
		);
	}

	/**
	 * Test file md5 validation.
	 *
	 * @return void
	 */
	public function testMd5() {
		$this->_validator->setMd5($this->_expectedHash);
		// test normal
		$this->assertTrue(
			$this->_validator->validate()
		);

		$this->_validator->setMd5(md5('anything but the right one...'));
		// test normal
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