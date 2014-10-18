<?php

/**
 * $Id$
 *
 * Spaf/tests/UnitTest.php
 * @created Tue Sep 25 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\tests;

/**
 * \Spaf\test\UnitTest
 *
 * Tool for running the unit tests
 *
 * @author Claudio Walser
 * @package Spaf\tests
 * @namespace Spaf\tests
 */
final class UnitTests {

	/**
	 * Not testable classes.
	 * Usually this should just contain this Class itself.
	 * Everythin else probably means those classes are not finished yet.
	 *
	 * @var array
	 */
	private $_notTestable = array(
		# This is the manager not a TestClass itself
		'\Spaf\tests\UnitTest',
		
		# dont work properly yet
		'\Spaf\tests\Unit\Library\Cache\Driver\ApcTest',
		'\Spaf\tests\Unit\Library\Cache\Driver\MemcacheTest'
	);

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
		$loader = new Autoloader(false);

		// find all test files - read one folder up and into tests to get the the full namespace by path
		$directory = new \Spaf\Library\Directory\Directory('../tests');
		$files = $directory->getChildren('*Test.php', 'file', true);

		$tests = array();
		foreach ($files as $file) {
			// @TODO Write a class Spaf\Library\Test\File for it maybe
			$fileName = $file->getPath() . $file->getName();
			$className = '\\Spaf\\' . str_replace(array('../', '.php', '/'), array('', '', '\\'), $fileName);
			$tests[] = array(
				'file' => $fileName,
				'class' => $className
			);
		}

		foreach ($tests as $key => $test) {
			if (in_array($test['class'], $this->_notTestable)) {
				unset($tests[$key]);
			}

			if (!is_readable($test['file'])) {
				//echo $test['file'] . '- file doesent exist' . "\n";
				//unset($tests[$key]);
			}

			if (!class_exists($test['class'])) {
				echo  $test['class'] . ' - class doesent exist' . "\n";
				unset($tests[$key]);
			}
		}

		// instantiate manager
		$manager = new \Spaf\tests\Unit\TestManager();
		// set array with tests
		$manager->setTests($tests);
		// run test manager
		$manager->run();
	}
}

// run
$test = new UnitTests();

?>
