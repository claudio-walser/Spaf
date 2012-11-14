<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Log/FileTest.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Log;

/**
 * \Spaf\_tests\Unit\Library\Log\FileTest
 *
 * The FileTest class tests any aspect of \Spaf\Library\Log\Writer\File.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Log
 * @namespace Spaf\_tests\Unit\Library\Log
 */
class FileTest extends \Spaf\_tests\Unit\TestCase {

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

	public function testEmptyFile() {
		$this->assertEquals(
			array(),
			$this->_file->getLines()
		);
	}

	public function testLogInfo() {
		$this->_logger->log(\Spaf\Library\Log\Manager::INFO, 'This is one test log');

		$this->assertEquals(
			array(
				'info	This is one test log'
			),
			$this->_file->getLines()
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
		$this->_logger->flush();


		unset($this->_logger);
		unset($this->_writer);
		unset($this->_file);
	}

}

?>