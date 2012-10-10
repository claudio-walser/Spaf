<?php

/**
 * $Id$
 *
 * Spaf/_tools/test.php
 * @created Tue Sep 25 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tools;

/**
 * \Spaf\_tools\Test
 *
 * Tool for running the tests
 *
 * @author Claudio Walser
 * @package Spaf\_tools
 * @namespace Spaf\_tools
 */
final class Test {

	/**
	 * Run the test tool
	 *
	 * @return void
	 */
	public function __construct() {
		// hack server argv for windows console
		if (!isset($_SERVER['argv']) && !empty($_GET)) {
			$_SERVER['argv'] = array('scriptname');

			foreach ($_GET as $key => $value) {
				$_SERVER['argv'][] = $key;
			}
		}

		// error reporting on
		error_reporting(E_ALL);

		// chdir to root test direcotry in any case
		chdir(__DIR__);

		// requiere test-autoloader environment
		require_once('autoloader.php');
		$loader = new \Spaf\_tools\Autoloader(false);

		// find all test files
		$directory = new \Spaf\Library\Directory\Directory('../_tests/');
		$files = $directory->getChildren('*Test.php', 'file', true);

		$tests = array();
		foreach ($files as $file) {
			// @TODO Write a class Spaf\Library\Test\File for it maybe
			$fileName = $file->getPath() . $file->getName();
			$className = '\\Spaf\\' . str_replace(array('..' . DIRECTORY_SEPARATOR, '.php', DIRECTORY_SEPARATOR), array('', '', '\\'), $fileName);
			$tests[] = array(
				'file' => $fileName,
				'class' => $className
			);
		}


		// instantiate manager
		$manager = new \Spaf\Library\Test\Cli();
		// set array with tests
		$manager->setTests($tests);
		// run test manager
		$manager->run();
	}
}

// run
$test = new Test();

?>