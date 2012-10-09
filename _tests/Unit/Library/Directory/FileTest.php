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
 * @package \Spaf\_tests\Unit\Library\Directory
 * @namespace \Spaf\_tests\Unit\Library\Directory
 */
class FileTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {}

	/**
	 * Test setRegistry and getRegistry.
	 * Means test it by normal registry object and test
	 * mock-object injection as well.
	 *
	 * @return void
	 */
	public function testSomething() {
		$this->assertTrue(true);
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