<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Directory/ManagerTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Directory;

/**
 * \Spaf\tests\Unit\Library\Directory\ManagerTest
 *
 * The ManagerTest class tests any aspect of \Spaf\Library\Directory\Manager.
 * For this test its very important to have the file notRedable.php in a non readable mode.
 * If some stuff fails here, do sudo chmod 0100 tests/Data/Directory/ToRead/notReadable
 * first and check again.
 *
 * @todo Test, or let me say, implement Mockable Classes for Directory and File
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Directory
 * @namespace Spaf\tests\Unit\Library\Directory
 */
class ManagerTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Manager object
	 *
	 * @var \Spaf\Library\
	 */
	private $_manager = null;

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$directory = $this->_getTestPath() . '/Data/';
		$this->testsDataBasePath = $directory;

		$this->_manager = new \Spaf\Library\Directory\Manager();

		unset($directory);
		unset($directories);
	}

	/**
	 * Test readContent in all variations.
	 *
	 * @note	If you run the command line test.php Script as root, this test will
	 * 			always fail cause root can read EVERYTHING
	 * 			if it does fail without beeing logged in as root
	 * 			chmod the file: sudo chmod 0100 tests/Data/Directory/ToRead/notReadable
	 *
	 * @return void
	 */
	public function testReadContent() {
		$directory = $this->testsDataBasePath . 'Directory/ToRead';

		// read and compare all
		$directoryContent = $this->_manager->readContent($directory);
		// has to have 3 elements
		$this->assertTrue(count($directoryContent) === 4);

		// read and compare only directories
		$directoryContent = $this->_manager->readContent($directory, '*', true);
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 2);

		// read and compare only php files
		$directoryContent = $this->_manager->readContent($directory, '*.php');
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 2);

		// read a file by pattern
		$directoryContent = $this->_manager->readContent($directory, '*pattern*');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);

		unset($directory);
		unset($directoryContent);
	}

	/**
	 * Test readContent with mocked objects.
	 *
	 * @return void
	 */
	public function testReadContentMocked() {
		$directory = $this->testsDataBasePath . 'Directory/ToRead';

		// set mock classes to read
		$this->_manager->setDirectoryClass('\Spaf\tests\Mock\Library\Directory\Directory');
		$this->_manager->setFileClass('\Spaf\tests\Mock\Library\Directory\File');
		// read and compare all
		$directoryContent = $this->_manager->readContent($directory);

		$this->assertEquals(
			'Spaf\tests\Mock\Library\Directory\Directory',
			get_class($directoryContent[0])
		);

		$this->assertEquals(
			'Spaf\tests\Mock\Library\Directory\File',
			get_class($directoryContent[1])
		);

		unset($directory);
		unset($directoryContent);
	}


	/**
	 * Test to create a directory
	 * And test to delete a directory at the same time
	 *
	 * @return void
	 */
	public function testCreateDirectory() {
		$newDirectory = $this->testsDataBasePath . 'Temp/TestCreateDirectory';
		$dirToDelete = $this->testsDataBasePath . 'Temp';

		// does not exists yet
		$this->assertFalse(
			$this->_manager->directoryExists($newDirectory)
		);

		$this->_manager->createDirectory($newDirectory);

		// has to exists now
		$this->assertTrue(
			$this->_manager->directoryExists($newDirectory)
		);


		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			$this->_manager->directoryExists($newDirectory)
		);
		$this->assertFalse(
			$this->_manager->directoryExists($dirToDelete)
		);

		unset($newDirectory);
		unset($dirToDelete);
		unset($directory);
	}

	/**
	 * Test to create a file
	 * And test to delete a file at the same time
	 *
	 * @return void
	 */
	public function testCreateFile() {
		$newFile = $this->testsDataBasePath . 'Temp/TestFile.tmp';
		$dirToDelete = $this->testsDataBasePath . 'Temp';

		// does not exists yet
		$this->assertFalse(
			$this->_manager->fileExists($newFile)
		);

		$this->_manager->createFile($newFile);

		// has to exists now
		$this->assertTrue(
			$this->_manager->fileExists($newFile)
		);

		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			$this->_manager->fileExists($newFile)
		);
		$this->assertFalse(
			$this->_manager->directoryExists($dirToDelete)
		);

		unset($newFile);
		unset($dirToDelete);
		unset($directory);
	}

	/**
	 * Test directory exists functionality
	 *
	 * @return void
	 */
	public function testDirectoryExists() {
		$doesExist = $this->testsDataBasePath;
		$doesNotExist = $this->testsDataBasePath . 'DoesNotExist';

		$this->assertTrue(
			$this->_manager->directoryExists($doesExist)
		);

		$this->assertFalse(
			$this->_manager->directoryExists($doesNotExist)
		);

		unset($doesExist);
		unset($doesNotExist);
	}

	/**
	 * Test file exists functionality
	 *
	 * @return void
	 */
	public function testFileExists() {
		$doesExist = $this->testsDataBasePath . 'Directory/ToRead/2.php';
		$doesNotExist = $this->testsDataBasePath . 'Directory/ToRead/doesNotExist.php';

		$this->assertTrue(
			$this->_manager->fileExists($doesExist)
		);

		$this->assertFalse(
			$this->_manager->fileExists($doesNotExist)
		);

		unset($doesExist);
		unset($doesNotExist);
	}

	/**
	 * Test file exists functionality
	 *
	 * @return void
	 */
	public function testFileIsReadable() {
		$doesExist = $this->testsDataBasePath . 'Directory/ToRead/2.php';
		$doesNotExist = $this->testsDataBasePath . 'Directory/ToRead/notReadable';

		$this->assertTrue(
			$this->_manager->fileIsReadable($doesExist)
		);

		// @note If you run the command line test.php Script as root, this test will
		//		 always fail cause root can read EVERYTHING
		// if it does fail without beeing logged in as root
		// chmod the file: sudo chmod 0100 tests/Data/Directory/ToRead/notReadable
		$this->assertFalse(
			$this->_manager->fileIsReadable($doesNotExist)
		);

		unset($doesExist);
		unset($doesNotExist);
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->_manager);
		unset($this->testsDataBasePath);
	}

}

?>