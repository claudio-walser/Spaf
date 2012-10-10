<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Directory/ManagerTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Directory;

/**
 * \Spaf\_tests\Unit\Library\Directory\ManagerTest
 *
 * The ManagerTest class tests any aspect of \Spaf\Library\Directory\Manager.
 * For this test its very important to have the file notRedable.php in a non readable mode.
 * If some stuff fails here, do sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
 * first and check again.
 *
 * @todo Test, or let me say, implement Mockable Classes for Directory and File
 * @author Claudio Walser
 * @package \Spaf\_tests\Unit\Library\Directory
 * @namespace \Spaf\_tests\Unit\Library\Directory
 */
class ManagerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {
		$directory = '/home/claudio.walser/sandboxes/Spaf/_tests/Unit/Library/Directory';
		$directory = __DIR__;

		$directories = explode(DIRECTORY_SEPARATOR, $directory);
		array_pop($directories);
		array_pop($directories);
		array_pop($directories);

		$directory = implode(DIRECTORY_SEPARATOR, $directories) . '/Data/';
		$this->_testsDataBasePath = $directory;

		unset($directory);
		unset($directories);
	}

	/**
	 * Test readContent in all variations.
	 *
	 * @note	If you run the command line test.php Script as root, this test will
	 * 			always fail cause root can read EVERYTHING
	 * 			if it does fail without beeing logged in as root
	 * 			chmod the file: sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
	 *
	 * @return void
	 */
	public function testReadContent() {
		$directory = $this->_testsDataBasePath . 'Directory/ToRead';

		// read and compare all
		$directoryContent = \Spaf\Library\Directory\Manager::readContent($directory);
		// has to have 3 elements
		$this->assertTrue(count($directoryContent) === 4);

		// read and compare only directories
		$directoryContent = \Spaf\Library\Directory\Manager::readContent($directory, '*', true);
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 2);

		// read and compare only php files
		$directoryContent = \Spaf\Library\Directory\Manager::readContent($directory, '*.php');
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 2);

		// read a file by pattern
		$directoryContent = \Spaf\Library\Directory\Manager::readContent($directory, '*pattern*');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);

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
		$newDirectory = $this->_testsDataBasePath . 'Temp/TestCreateDirectory';
		$dirToDelete = $this->_testsDataBasePath . 'Temp';

		// does not exists yet
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::directoryExists($newDirectory)
		);

		\Spaf\Library\Directory\Manager::createDirectory($newDirectory);

		// has to exists now
		$this->assertTrue(
			\Spaf\Library\Directory\Manager::directoryExists($newDirectory)
		);


		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::directoryExists($newDirectory)
		);
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::directoryExists($dirToDelete)
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
		$newFile = $this->_testsDataBasePath . 'Temp/TestFile.tmp';
		$dirToDelete = $this->_testsDataBasePath . 'Temp';

		// does not exists yet
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::fileExists($newFile)
		);

		\Spaf\Library\Directory\Manager::createFile($newFile);

		// has to exists now
		$this->assertTrue(
			\Spaf\Library\Directory\Manager::fileExists($newFile)
		);

		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::fileExists($newFile)
		);
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::directoryExists($dirToDelete)
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
		$doesExist = $this->_testsDataBasePath;
		$doesNotExist = $this->_testsDataBasePath . 'DoesNotExist';

		$this->assertTrue(
			\Spaf\Library\Directory\Manager::directoryExists($doesExist)
		);

		$this->assertFalse(
			\Spaf\Library\Directory\Manager::directoryExists($doesNotExist)
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
		$doesExist = $this->_testsDataBasePath . 'Directory/ToRead/2.php';
		$doesNotExist = $this->_testsDataBasePath . 'Directory/ToRead/doesNotExist.php';

		$this->assertTrue(
			\Spaf\Library\Directory\Manager::fileExists($doesExist)
		);

		$this->assertFalse(
			\Spaf\Library\Directory\Manager::fileExists($doesNotExist)
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
		$doesExist = $this->_testsDataBasePath . 'Directory/ToRead/2.php';
		$doesNotExist = $this->_testsDataBasePath . 'Directory/ToRead/notReadable.php';

		$this->assertTrue(
			\Spaf\Library\Directory\Manager::fileIsReadable($doesExist)
		);

		// @note If you run the command line test.php Script as root, this test will
		//		 always fail cause root can read EVERYTHING
		// if it does fail without beeing logged in as root
		// chmod the file: sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
		$this->assertFalse(
			\Spaf\Library\Directory\Manager::fileIsReadable($doesNotExist)
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
		unset($this->_testsDataBasePath);
	}

}

?>