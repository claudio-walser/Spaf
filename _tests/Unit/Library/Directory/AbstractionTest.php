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
	}

	/**
	 * Test readContent in all variations.
	 *
	 * @return void
	 */
	public function testReadContent() {
		$directory = $this->_testsDataBasePath . 'Directory/ToRead';

		// read and compare all
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory);
		// has to have 3 elements
		$this->assertTrue(count($directoryContent) === 3);

		// read and compare only directories
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*', true);
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);

		// read and compare only php files
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*.php');
		// has to have 2 elements
		$this->assertTrue(count($directoryContent) === 2);

		// read a file by pattern
		$directoryContent = \Spaf\Library\Directory\Abstraction::readContent($directory, '*pattern*');
		// has to have 1 element
		$this->assertTrue(count($directoryContent) === 1);
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
	}

	/**
	 * Test to create a directory
	 */
	public function testCreateDirectory() {
		$newDirectory = $this->_testsDataBasePath . 'Temp/TestCreateDirectory';
		$dirToDelete = $this->_testsDataBasePath . 'Temp';

		// does not exists yet
		$this->assertFalse(\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory));

		\Spaf\Library\Directory\Abstraction::createDirectory($newDirectory);

		// has to exists now
		$this->assertTrue(\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory));


		// delete it again and check its deletion, even if its not specially part of this test
		$directory = new \Spaf\Library\Directory\Directory($dirToDelete);
		$directory->delete();

		// does not exists anymore
		$this->assertFalse(\Spaf\Library\Directory\Abstraction::directoryExists($newDirectory));
		$this->assertFalse(\Spaf\Library\Directory\Abstraction::directoryExists($dirToDelete));
	}

	/**
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {}

}

?>