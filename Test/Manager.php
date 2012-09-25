#!/bin/env php
<?php
namespace Spaf\Test;

error_reporting(E_ALL);

class Manager {

	private $_runner = null;
	private $_suite = null;
	private $_options = array(
		'help' => array(
			'description' => 'Just output a help for all possible parameters you can pass to this script. The helps is shown as default, so testing should be straigt forward.',
			'usage' => array(
				'php -f path/to/Spaf/Test/Manager.php',
				'php -f path/to/Spaf/Test/Manager.php help',
				
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
			'description' => 'Really call the tests. As second and third param, you can pass TestClass and TestMethod which both can be wildcards as well.',
			'usage' => array(
				'php -f path/to/Spaf/Test/Manager.php execute',
				'php -f path/to/Spaf/Test/Manager.php execute TestClass',
				'php -f path/to/Spaf/Test/Manager.php execute TestClass testMethod'
			
			)
		)
	);
	private $_nonTestFolders = array(
		'.',
		'..',
		'Mock'
	);
	private $_arguments = array();
	private $_method = 'help';
	private $_tests = array();
	private $_classPrefix = 'Spaf';
	
	public function __construct() {
		require_once('Autoloader.php');
		$loader = new Autoloader();
		
		$this->_runner	= new \PHPUnit_TextUI_TestRunner();
		$this->_suite = new \PHPUnit_Framework_TestSuite('Spaf - Test Suite');
	}
	
	public function setClassPrefix($prefix) {
		$this->_classPrefix = (string) $prefix;
	}
	
	public function run() {
		$this->_fetchArguments();
		// call given method if exists
		if (method_exists($this, $this->_method)) {
			call_user_func(array($this, $this->_method));
		}
		
		return true;
		
	}

	public function cliVersion()
	{
		echo "Spaf Test Runner" . "\n";
		echo "built on ";
		\PHPUnit_TextUI_TestRunner::printVersionString();
	}

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
	}

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
	
	
	private function _fetchTests($directory = './') {
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
				$file = substr($file, 2);
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


$manager = new \Spaf\Test\Manager();
$manager->setClassPrefix('Spaf');
$manager->run();
?>