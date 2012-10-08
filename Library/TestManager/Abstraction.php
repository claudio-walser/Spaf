<?php

/**
 * $Id$
 *
 * Spaf/Library/TestManager/Abstraction.php
 * @created Wed Sep 26 19:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\TestManager;

/**
 * \Spaf\Library\TestManager\Abstraction
 *
 * The Cli Test Manager class provides an interface for running the unit tests easely.
 *
 * @author Claudio Walser
 * @package Spaf\Library\TestManager
 * @namespace Spaf\Library\TestManager
 */
class Abstraction {

	/**
	 * PHPUnit TestSuite
	 *
	 * @var PHPUnit_TextUI_TestRunner
	 */
	private $_runner = null;

	/**
	 * PHPUnit TestSuite
	 *
	 * @var PHPUnit_Framework_TestSuite
	 */
	private $_suite = null;

	/**
	 * Options usage for help
	 *
	 * @var array
	 */
	private $_options = array(
		'help' => array(
			'description' => 'Just output a help for all possible parameters you can pass to this script. The helps is shown as default, so testing should be straigt forward.',
			'usage' => array(
				'php -f path/to/Spaf/Test/Manager.php',
				'php -f path/to/Spaf/Test/Manager.php help'
			)
		),
		'version' => array(
			'description' => 'See what version the Test Manager currently has.',
			'usage' => array('php -f path/to/Spaf/Test/Manager.php version')
		),
		'list' => array(
			'description' => 'List all possible tests.',
			'usage' => array('php -f path/to/Spaf/Test/Manager.php list')
		),
		'execute' => array(
			'description' => 'Really call the tests. As second and third param,
			 you can pass TestClass and TestMethod which both can be wildcards as well.',
			'usage' => array(
				'php -f path/to/Spaf/Test/Manager.php execute',
				'php -f path/to/Spaf/Test/Manager.php execute TestClass',
				'php -f path/to/Spaf/Test/Manager.php execute TestClass testMethod'

			)
		)
	);

	/**
	 * Folders with no test classes in it for sure
	 *
	 * @var array
	 */
	private $_nonTestFolders = array(
		'.',
		'..',
		'Mock'
	);

	/**
	 * Given arguments
	 *
	 * @var array
	 */
	private $_arguments = array();

	/**
	 * Current cli method to call, help by default
	 *
	 * @var string
	 */
	private $_method = 'help';

	/**
	 * Found tests, an array with class-and filenames
	 *
	 * @var array
	 */
	private $_tests = array();

	/**
	 * Class prefix for test classes
	 *
	 * @var string
	 */
	private $_classPrefix = 'Spaf\\tests';

	/**
	 * Constructor ist setting up a PHPUnit Runner and Suite
	 */
	public function __construct() {
		$this->_runner	= new \PHPUnit_TextUI_TestRunner();
		$this->_suite = new \PHPUnit_Framework_TestSuite('Spaf - Test Suite');
	}

	/**
	 * Set a class prefix to execute the test classes
	 *
	 * @param string Class prefix, usually the namespace your are running in
	 * @return boolean true
	 */
	public function setClassPrefix($prefix) {
		$this->_classPrefix = (string) $prefix;

		return true;
	}

	/**
	 * Run the right cliMethod by given params.
	 *
	 * @return boolean true
	 */
	public function run() {
		$this->_fetchArguments();
		// call given method if exists
		if (method_exists($this, $this->_method)) {
			call_user_func(array($this, $this->_method));
		}

		return true;
	}

	/**
	 * Version method for cli
	 * Is called by passing version as first param to the cli.php script.
	 * This method is outputting the current Manager Version.
	 *
	 * @return boolean true
	 */
	public function cliVersion()
	{
		echo "Spaf Test Runner" . "\n";
		echo "built on ";
		\PHPUnit_TextUI_TestRunner::printVersionString();
	}

	/**
	 * Help method for cli
	 * Is called by passing help or nothing as first param to the cli.php script.
	 * This method is outputting a help for the whole functionality
	 *
	 * @return boolean true
	 */
	public function cliHelp() {
		$this->cliVersion();

		echo "This is just a small help about the Test Manager class. It is intuitive and easy to use." . "\n\n";
		foreach ($this->_options as $key => $option) {
			echo $this->_getColorizedString($key) . "\t";
			echo 'Description: ' . $option['description'] . "\n\n";

			foreach ($option['usage'] as $usage) {
				echo "\tUsage: " . $this->_getColorizedString($usage, 'code') . "\n";
			}

			echo "\n\n";
		}

		return true;
	}

	/**
	 * List method for cli
	 * Is called by passing list as first param to the cli.php script.
	 * This method is listing all the found tests and its methods.
	 *
	 * @return boolean true
	 */
	public function cliList() {
		$this->cliVersion();

		echo 'This is a list of all test classes and their methods, found by this manager.' . "\n\n";

		$this->_fetchTests();
		foreach ($this->_tests as $test) {
			$reflection = new \ReflectionClass($test['class']);
			$methods = $reflection->getMethods();
			echo $this->_getColorizedString($test['class']) . "\n";
			foreach ($methods as $method) {
				if ($method->getDeclaringClass() == $reflection && substr($method->name, 0, 4) === 'test') {
					echo "\t" . $method->name . "\n";
				}
			}
			echo "\n";
		}

		return true;
	}

	/**
	 * Execute method for cli
	 * Is called by passing execute as first param to the cli.php script.
	 * For now, it just simply executes all the found tests.
	 *
	 * @return boolean true
	 */
	public function cliExecute() {
		$this->_fetchTests();
		foreach ($this->_tests as $test) {
			$this->_runner->getLoader()->load($test['class'], $test['file']);
			$this->_suite->addTestSuite($test['class']);
		}

		if($this->_suite->count() === 0) {
			$this->cliVersion();
			echo 'No tests found in the current working directory.' . "\n\n";
			exit(\PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT);
		}

		try {
			$this->cliVersion();
			$params = array(
				'verbose' => true
			);
			$result = $this->_runner->doRun($this->_suite, $params);
		} catch (Exception $e) {
			echo $e->getMessage() . "\n\n";
			exit(\PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT);
		}

		if ($result->wasSuccessful()) {
			exit(\PHPUnit_TextUI_TestRunner::SUCCESS_EXIT);
		} else if($result->errorCount() > 0) {
			exit(\PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT);
		} else {
			exit(\PHPUnit_TextUI_TestRunner::FAILURE_EXIT);
		}

		return true;
	}


	/**
	 * Fetches available tests by seeking a folder.
	 * Every File with postfix *Test.php is considered as a test file.
	 * This method stores the file and class name in a internal array property
	 *
	 * @param string Current directory to search in
	 * @return boolean true
	 */
	private function _fetchTests($directory = './') {
		// @TODO Take lines below to recursivly find tests
		//$directory = new \Spaf\Library\Directory\Directory('../');
		//$files = $directory->getChildren(true, '*Test.php', 'file');

		// go for spl directory iterator
		$iterator = new \DirectoryIterator($directory);
		// iterate
		foreach($iterator as $item) {
			// if directory
			if($item->isDir()) {
				// if non testable folder
				if(in_array($item->getFilename(), $this->_nonTestFolders)) {
					continue;
				}
				// recursion
				$this->_fetchTests($item->getPath() . DIRECTORY_SEPARATOR . $item->getFilename());
			}

			// if a testfile
			if (substr($item->getFilename(), -8) === 'Test.php') {
				$file = $item->getPath() . DIRECTORY_SEPARATOR . $item->getFilename();
				$file = '' . substr($file, 2);
				$class = '\\' . $this->_classPrefix . '\\' . str_replace(array('.php', DIRECTORY_SEPARATOR), array('', '\\'), $file);
				// push internal _tests property
				array_push($this->_tests, array(
					'file' => $file,
					'class' =>  $class
				));
			}
		}

		return true;
	}

	/**
	 * Fetches arguments from cli call
	 * and stores in a class property.
	 *
	 * @return boolean true
	 */
	private function _fetchArguments() {
		// fet cli arguments
		$arguments = $_SERVER['argv'];

		// remove first element cause its the script-name itself
		array_shift($arguments);
		// check method name allowed
		if (count($arguments) == 0 || !array_key_exists($arguments[0], $this->_options)) {
			$arguments[0] = $this->_method;
		}
		// set props
		$this->_arguments = $arguments;
		$this->_method = 'cli' . ucfirst(array_shift($this->_arguments));

		return true;
	}

	/**
	 * Returns colorized string for command line interface
	 *
	 * @param string String to colorize
	 * @param string Type for coloring (key||code, default to key)
	 * @return string Colorized string
	 */
	private function _getColorizedString($string, $type = 'key') {
		switch ($type) {
			default: // green to default
				$colorizedString = "\033[0;30m" . "\033[42m" . $string . "\033[0m";
				break;

			case 'code': // green to default
				$colorizedString = "\033[0;30m" . "\033[46m" . $string . "\033[0m";
				break;
		}

		return $colorizedString;
	}

}

?>