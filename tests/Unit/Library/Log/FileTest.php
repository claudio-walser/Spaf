<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Log/FileTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Log;

/**
 * \Spaf\tests\Unit\Library\Log\FileTest
 *
 * The FileTest class tests any aspect of \Spaf\Library\Log\Writer\File.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Log
 * @namespace Spaf\tests\Unit\Library\Log
 */
class FileTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Log instance
	 *
	 * @var \Spaf\Library\Log\
	 */
	private $_logger = null;

	/**
	 * Log writer instance
	 *
	 * @var \Spaf\Library\Log\Writer\File
	 */
	private $_writer = null;

	/**
	 * File instance for log writer
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	private $_file = null;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$this->_logger = new \Spaf\Library\Log\Manager();
		$this->_writer = new \Spaf\Library\Log\Writer\File();

		$logFilePath = $this->_getTestPath() . '/Data/Log/File.txt';
		$this->_file = new \Spaf\Library\Directory\File($logFilePath);

		$this->_writer->setSourceFile($this->_file);
		$this->_logger->addWriter($this->_writer);
	}

	/**
	 * Test log file is empty initially
	 *
	 * @return void
	 */
	public function testEmptyFile() {
		$this->assertEquals(
			array(),
			$this->_file->getLines()
		);
	}

	/**
	 * Test log info message
	 *
	 * @return void
	 */
	public function testLogInfo() {
		$this->_logger->info('This is an info log');

		$this->assertEquals(
			array(
				\Spaf\Library\Log\Manager::INFO . "\t" . 'This is an info log'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Test log error message
	 *
	 * @return void
	 */
	public function testLogError() {
		$this->_logger->error('This is an error log');

		$this->assertEquals(
			array(
				\Spaf\Library\Log\Manager::ERROR . "\t" . 'This is an error log'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Test log warning message
	 *
	 * @return void
	 */
	public function testLogWarning() {
		$this->_logger->warning('This is a warning log');

		$this->assertEquals(
			array(
				\Spaf\Library\Log\Manager::WARNING . "\t" . 'This is a warning log'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Test log critical message
	 *
	 * @return void
	 */
	public function testLogCritical() {
		$this->_logger->critical('This is a critical log');

		$this->assertEquals(
			array(
				\Spaf\Library\Log\Manager::CRITICAL . "\t" . 'This is a critical log'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Test log some multiple whitespaces and newlines
	 *
	 * @return void
	 */
	public function testLogWhitespaces() {
		$this->_logger->info('This is a log with new lines
															  and a lot of white spaces');

		$this->assertEquals(
			array(
				\Spaf\Library\Log\Manager::INFO . "\t" . 'This is a log with new lines and a lot of white spaces'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Test a non pre defined log type as well
	 *
	 * @return void
	 */
	public function testWeirdType() {
		$this->_logger->weird('A weird log entry');

		$this->assertEquals(
			array(
				'weird' . "\t" . 'A weird log entry'
			),
			$this->_file->getLines()
		);
	}

	/**
	 * Assert getting writers source file is still the same instance
	 *
	 * @return void
	 */
	public function testGetSourceFile() {
		$this->assertEquals(
			$this->_file,
			$this->_writer->getSourceFile()
		);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		// empty the log file
		$this->_logger->clear();

		unset($this->_logger);
		unset($this->_writer);
		unset($this->_file);
	}

}

?>