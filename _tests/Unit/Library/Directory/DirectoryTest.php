<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Directory/DirectoryTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Directory;

/**
 * \Spaf\_tests\Unit\Library\Directory\DirectoryTest
 *
 * The DirectoryTest class tests any aspect of \Spaf\Library\Directory\Directory.
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Unit\Library\Directory
 * @namespace Spaf\_tests\Unit\Library\Directory
 */
class DirectoryTest extends \Spaf\_tests\Unit\TestCase {

	/**
	 * Directory instance
	 *
	 * @var \Spaf\Library\Directory\Directory
	 */
	private $_directory = null;

	/**
	 * Path of the test folder
	 *
	 * @var string
	 */
	private $_testPath = '';

	/**
	 * Name of the test folder
	 *
	 * @var string
	 */
	private $_testName = 'ToRead';

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
		$this->_manager = new \Spaf\Library\Directory\Manager();

		$this->_testPath = $this->_getTestPath() . '/Data/Directory/';
		$directory = $this->_testPath . $this->_testName .  '/';
		$this->_directory = new \Spaf\Library\Directory\Directory($directory);

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
			$this->_directory->getName()
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
			$this->_directory->getPath()
		);
	}

	/**
	 * Test getChildren in all variations.
	 *
	 * @note	If you run the command line test.php Script as root, this test will
	 * 			always fail cause root can read EVERYTHING
	 * 			if it does fail without beeing logged in as root
	 * 			chmod the file: sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
	 *
	 * @return void
	 */
	public function testGetChildren() {
		// read and compare all
		$directoryContent = $this->_directory->getChildren();
		// has to have 3 elements
		$this->assertTrue(count($directoryContent) === 4);

		// read and compare only directories
		$directoryContent = $this->_directory->getChildren('*', 'directory');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 2);

		// read and compare only php files
		$directoryContent = $this->_directory->getChildren('*.php');
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 2);

		// read a file by pattern
		$directoryContent = $this->_directory->getChildren('*pattern*');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);

		// test fetching files recursive
		// read and compare only php files
		$directoryContent = $this->_directory->getChildren('*.php', 'file', true);
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 4);

		// test fetching files recursive
		// read and compare only php files
		// and respect ignore array
		$directoryContent = $this->_directory->getChildren('*.php', 'file', true, array('ignore'));
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 3);

		unset($directory);
		unset($directoryContent);
	}

	/**
	 * Test getChildren in with mocked objects.
	 *
	 * @return void
	 */
	public function testGetChildrenMocked() {
		// set mock classes to read
		$this->_directory->setDirectoryClass('\Spaf\_tests\Mock\Library\Directory\Directory');
		$this->_directory->setFileClass('\Spaf\_tests\Mock\Library\Directory\File');

		$directoryContent = $this->_directory->getChildren();


		foreach ($directoryContent as $content) {
			$this->assertTrue(
				get_class($content) === 'Spaf\_tests\Mock\Library\Directory\Directory' ||
				get_class($content) === 'Spaf\_tests\Mock\Library\Directory\File'
			);
		}

		unset($directoryContent);
	}

	/**
	 * Test to delete a directory with all its content
	 *
	 * @return void
	 */
	public function testDelete() {
		$folderToDelete = $this->_directory->getPath() . $this->_directory->getName() . '/Temp/';
		$newFile = $folderToDelete . '/Demo/TestFile.tmp';

		// check not exists subfolders and file
		$this->assertFalse(
			$this->_manager->fileExists($newFile)
		);
		$this->assertFalse(
			$this->_manager->directoryExists($folderToDelete)
		);

		// create subfolders and file
		$this->_manager->createFile($newFile);

		// check exists subfolders and file
		$this->assertTrue(
			$this->_manager->fileExists($newFile)
		);
		$this->assertTrue(
			$this->_manager->directoryExists($folderToDelete)
		);

		// delete main dir recursive
		$directory = new \Spaf\Library\Directory\Directory($folderToDelete);
		$directory->delete();

		// check not exists subfolders and file
		$this->assertFalse(
			$this->_manager->fileExists($newFile)
		);
		$this->assertFalse(
			$this->_manager->directoryExists($folderToDelete)
		);

		unset($folderToDelete);
		unset($newFile);
		unset($directory);

	}

	/**
	 * Directory has to throw an exception if you try to create
	 * an object from a non existent folder.
	 *
	 * @return void
	 */
	public function testConstructException() {
		$this->setExpectedException('\\Spaf\\Library\\Directory\\Exception');
		$directory = new \Spaf\Library\Directory\Directory('notExistent');

		unset($directory);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_manager);
		unset($this->_directory);
		unset($this->_testName);
		unset($this->_testPath);
	}

}

?>