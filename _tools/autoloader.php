<?php

/**
 * $Id$
 *
 * Spaf/_tests/autoloader.php
 * @created Wed Sep 26 20:26:27 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Unit;

// Spaf abstract autoloader class for extending here
require_once('../Core/Autoloader.php');

/**
 * \Spaf\_tests\Autoloader
 *
 * Autoloader for test environment.
 *
 * @author Claudio Walser
 * @package \Spaf\_tests\Mock\Core
 * @namespace \Spaf\_tests\Mock\Core
 */
final class Autoloader Extends \Spaf\Core\Autoloader {
	
	/**
	 * Load the only needed phpunit file by hand.
	 * Then call parent, which is loading any of our functions below
	 * as spl_autoload and passing $name as first and only param.
	 */
	public function __construct() {
		// phpunit procedural autoload functions
		require_once('/usr/share/php/PHPUnit/Autoload.php');
		
		parent::__construct();
	}
	
	/**
	 * Autoloader for the Cwa Framework classes
	 *
	 * @param		String		Classname with complete namespace
	 * @return		boolean
	 */
	public function Spaf($name) {
		$file = $this->_getFilename($name);
		$file = '../../' . $file;
		
		$this->debug($file . "<br />\n");

		if (is_file($file) && is_readable($file)) {
			// do debug message if needed
			$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' successfully loaded' . "<br />\n");
			// require the file
			require_once($file);
			return true;
		} else {
			$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' not found; include_path:' . get_include_path() . "<br />\n");
			return false;
		}
	}
	
}

?>