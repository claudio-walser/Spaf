<?php
namespace Spaf\tests;

// Spaf abstract autoloader class
require_once('../Library/Autoloader.php');
// phpunit procedural autoload functions
require_once('/usr/share/php/PHPUnit/Autoload.php');


final class Autoloader Extends \Spaf\Library\Autoloader {

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
		}
	}

	/**
	 * Autoloader for my Documentor classes
	 *
	 * @param		String		Classname with complete namespace
	 * @return		boolean
	 */
	public function PHPUnit($name) {
		$file = '/usr/share/php/' . $this->_getFilename($name, '_');
		
		$this->debug($file . "<br />\n");
		
		if (is_file($file) && is_readable($file)) {
			// do debug message if needed
			$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' successfully loaded' . "<br />\n");
			// require the file
			require_once($file);
			return true;
		} else {
			$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' not found; include_path:' . get_include_path() . "<br />\n");
		}
	}

}


?>