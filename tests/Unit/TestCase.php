<?php

/**
 * $Id$
 *
 * Spaf/tests/Unit/TestCase.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests\Unit;

/**
 * \Spaf\tests\Unit\TestCase
 *
 * Abstract TestCase for Spaf unit-tests.
 *
 * @author Claudio Walser
 * @package Spaf\tests\Unit
 * @namespace Spaf\tests\Unit
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * Get path to the current directory
	 *
	 * @return void
	 */
	protected function _getTestPath() {
		// build the full path
		$directory = __DIR__;

		$directories = explode(DIRECTORY_SEPARATOR, $directory);
		array_pop($directories);
		//array_pop($directories);
		//array_pop($directories);


		$path = implode(DIRECTORY_SEPARATOR, $directories);

		return $path;
	}

}

?>