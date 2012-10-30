<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Directory/FileTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Directory;

/**
 * \Spaf\_tests\Unit\Library\Directory\FileTest
 *
 * The FileTest class tests any aspect of \Spaf\Library\Directory\File.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Directory
 * @namespace Spaf\_tests\Unit\Library\Directory
 */
class FileTest extends \PHPUnit_Framework_TestCase {

	/**
	 * File instance
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	private $_file = null;

	/**
	 * Path of the test file
	 *
	 * @var string
	 */
	private $_testPath = '';

	/**
	 * Name of the test file
	 *
	 * @var string
	 */
	private $_copyName = '2-copy.php';

	/**
	 * Name of the test file
	 *
	 * @var string
	 */
	private $_testName = '2.php';

	/**
	 * Default content of the test file
	 *
	 * @sorry Ugly but it has to be :p
	 * @var string
	 */
	private $_defaultContent = '<?php
// testfile 2
?>';

	/**
	 * New Content to test set functions
	 *
	 * @sorry Ugly but it has to be :p
	 * @var string
	 */
	private $_newContent = '<?php
// this has to be written
?>';

	/**
	 * Manager object
	 *
	 * @var \Spaf\Library\Directory\Manager
	 */
	private $_manager = null;

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
		array_push($directories, 'Directory');
		array_push($directories, 'ToRead');


		$this->_testPath = implode(DIRECTORY_SEPARATOR, $directories) . '/';
		$file = $this->_testPath . $this->_testName;
		$this->_file = new \Spaf\Library\Directory\File($file);

		$this->_manager = new \Spaf\Library\Directory\Manager();

		unset($directory);
		unset($directories);
	}

	/**
	 * Test getName.
	 *
	 * @return void
	 */
	public function testGetName() {
		$this->assertEquals(
			$this->_testName,
			$this->_file->getName()
		);
	}

	/**
	 * Test getPath.
	 *
	 * @return void
	 */
	public function testGetPath() {
		$this->assertEquals(
			$this->_testPath,
			$this->_file->getPath()
		);
	}

	/**
	 * Test getContent, this should be as default.
	 *
	 * @return void
	 */
	public function testGetContent() {
		$this->assertEquals(
			$this->_defaultContent,
			$this->_file->getContent()
		);
	}

	/**
	 * Test getLines, this should be as splitted default.
	 *
	 * @return void
	 */
	public function testGetLines() {
		// compare
		$this->assertEquals(
			explode("\n", $this->_defaultContent),
			$this->_file->getLines()
		);
	}

	/**
	 * Test setContent
	 *
	 * @return void
	 */
	public function testSetContent() {
		// set new content
		$this->_file->setContent($this->_newContent);

		// assert normal content
		$this->assertEquals(
			$this->_newContent,
			$this->_file->getContent()
		);

		// assert lines
		$this->assertEquals(
			explode("\n", $this->_newContent),
			$this->_file->getLines()
		);

		// set default content back
		$this->_file->setContent($this->_defaultContent);
	}

	/**
	 * Test setLines
	 *
	 * @return void
	 */
	public function testSetLines() {
		// set new content
		$this->_file->setLines(explode("\n", $this->_newContent));

		// assert lines
		$this->assertEquals(
			explode("\n", $this->_newContent),
			$this->_file->getLines()
		);

		// assert normal content
		$this->assertEquals(
			$this->_newContent,
			$this->_file->getContent()
		);

		// set default content back
		$this->_file->setContent($this->_defaultContent);
	}

	/**
	 * Test setWrite
	 *
	 * @return void
	 */
	public function testWrite() {
		// write new content
		$this->_file->setContent($this->_newContent);
		$this->_file->write();

		// create a new instance to be sure its written and not just modified the object internally
		$file = new \Spaf\Library\Directory\File($this->_testPath . $this->_testName);

		// check on new content on new instance
		$this->assertEquals(
			$this->_newContent,
			$file->getContent()
		);

		// put back normal content and save
		$this->_file->setContent($this->_defaultContent);
		$this->_file->write();

		// test write to a new location
		$this->_file->setLines(explode("\n", $this->_newContent));
		$this->_file->write($this->_testPath . $this->_copyName);

		// create a new instance to be sure its written and not just modified the object internally
		$file = new \Spaf\Library\Directory\File($this->_testPath . $this->_copyName);

		// check on new content on new instance
		$this->assertEquals(
			$this->_newContent,
			$file->getContent()
		);

	}

	/**
	 * Test setWrite
	 *
	 * @return void
	 */
	public function testDelete() {
		$file = new \Spaf\Library\Directory\File($this->_testPath . $this->_copyName);
		$file->delete();

		// check if its really gone
		$this->setExpectedException('\\Spaf\\Library\\Directory\\Exception');
		$file = new \Spaf\Library\Directory\File($this->_testPath . $this->_copyName);
	}

	/**
	 * Directory has to throw an exception if you try to create
	 * an object from a non existent folder.
	 *
	 * @return void
	 */
	public function testConstructException() {
		$this->setExpectedException('\\Spaf\\Library\\Directory\\Exception');
		$file = new \Spaf\Library\Directory\File('notExistent.tmp');

		unset($file);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_manager);
		unset($this->_file);
		unset($this->_testName);
		unset($this->_testPath);
		unset($this->_defaultContent);
	}

}

?>