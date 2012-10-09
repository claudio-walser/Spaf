<?php

/**
 * $Id$
 *
 * Spaf/_tests/Unit/Library/Directory/AbstractionTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit\Library\Directory;

/**
 * \Spaf\_tests\Unit\Library\Directory\AbstractionTest
 *
 * The AbstractionTest class tests any aspect of \Spaf\Library\Directory\Abstraction.
 * For this test its very important to have the file notRedable.php in a non readable mode.
 * If some stuff fails here, do sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
 * first and check again.
 *
 * @author Claudio Walser
 * @package \Spaf\_tests\Unit\Library\Directory
 * @namespace \Spaf\_tests\Unit\Library\Directory
 */
class AbstractionTest extends \PHPUnit_Framework_TestCase {

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
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory);
		// has to have 3 elements
		$this->assertTrue(count($directoryContent) === 4);

		// read and compare only directories
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*', true);
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 2);

		// read and compare only php files
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*.php');
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 2);

		// read a file by pattern
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*pattern*');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);

		unset($directory);
		unset($directoryContent);
	}

	/**
	 * Test format a path with or without trailing slash
	 *
	 * @return void
	 */
	public function testFormPath() {
		$withSlash = '/test/path/';
		$withoutSlash = '/test/path';

		// check remove trailing slash
		$this->assertEquals(
			$withoutSlash,
			\Spaf\Library\Directory\Abstraction::formPath($withSlash, false)
		);

		// check add trailing slash
		$this->assertEquals(
			$withSlash,
			\Spaf\Library\Directory\Abstraction::formPath($withoutSlash, true)
		);

		unset($withSlash);
		unset($withoutSlash);
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
			\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory)
		);

		\Spaf\Library\Directory\Abstraction::createDirectory($newDirectory);

		// has to exists now
		$this->assertTrue(
			\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory)
		);


		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory)
		);
		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::directoryExists($dirToDelete)
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
			\Spaf\Library\Directory\Abstraction::fileExists($newFile)
		);

		\Spaf\Library\Directory\Abstraction::createFile($newFile);

		// has to exists now
		$this->assertTrue(
			\Spaf\Library\Directory\Abstraction::fileExists($newFile)
		);

		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::fileExists($newFile)
		);
		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::directoryExists($dirToDelete)
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
			\Spaf\Library\Directory\Abstraction::directoryExists($doesExist)
		);

		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::directoryExists($doesNotExist)
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
			\Spaf\Library\Directory\Abstraction::fileExists($doesExist)
		);

		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::fileExists($doesNotExist)
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
			\Spaf\Library\Directory\Abstraction::fileIsReadable($doesExist)
		);

		// @note If you run the command line test.php Script as root, this test will
		//		 always fail cause root can read EVERYTHING
		// if it does fail without beeing logged in as root
		// chmod the file: sudo chmod 0100 _tests/Data/Directory/ToRead/notReadable.php
		$this->assertFalse(
			\Spaf\Library\Directory\Abstraction::fileIsReadable($doesNotExist)
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