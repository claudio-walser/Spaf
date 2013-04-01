<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/Library/Directory/AbstractionTest.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit\Library\Directory;

/**
 * \Spaf\tests\Unit\Library\Directory\AbstractionTest
 *
 * The AbstractionTest class tests any aspect of \Spaf\Library\Directory\Abstraction.
 * For this test its very important to have the file notRedable.php in a non readable mode.
 * If some stuff fails here, do sudo chmod 0100 tests/Data/Directory/ToRead/notReadable.php
 * first and check again.
 *
 * @todo Test, or let me say, implement Mockable Classes for Directory and File
 * @author Claudio Walser
 * @package Spaf\tests\Unit\Library\Directory
 * @namespace Spaf\tests\Unit\Library\Directory
 */
class AbstractionTest extends \Spaf\tests\Unit\TestCase {

	/**
	 * Setup
	 *
	 * @return void
	 */
	protected function setUp() {}

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
	 * Release some memory maybe
	 * (guess not since the instance is still somewhere, just not in this class as prop)
	 *
	 * @return void
	 */
	public function tearDown() {}

}

?>