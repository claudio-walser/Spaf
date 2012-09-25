<?php
/**
 * $ID$
 *
 * Autoloader.php test
 */
 
namespace Spaf\Test;

/**
 * Autoloader class
 * For new packages/libraries, just define your own autoloader method
 * and add it to Autoloader::register().
 *
 * @author		Claudio Walser
 */
final class Autoloader {

	/**
	 * Debugging true or false
	 *
	 * @var bool
	 */
	private $_debug = true;

	/**
	 * Methods which are no autoloader
	 *
	 * @var array
	 */
	private $_noLoaderMethods = array('__construct', 'setDebug', '_getFilename', '_register');


	public function __construct($debug = false) {
		$this->setDebug($debug);
		$this->_register();
	}



	/**
	 * Class interna
	 */

	/**
	 * Enable or disable the debug mode.
	 * Every file load will be outputed.
	 *
	 * @param		boolean		true for enable debug mode, false for disable it
	 * @return		boolean
	 */
	public function setDebug($bool) {
		$this->_debug = (bool) $bool;
		return true;
	}

	private function _getFilename($class, $separator = '\\') {
		// get the file path from namespace and classname
		$file = str_replace($separator, DIRECTORY_SEPARATOR, $class) . '.php';

		// remove first slash
		if (substr($file, 0, strlen(DIRECTORY_SEPARATOR)) === DIRECTORY_SEPARATOR) {
			$file = substr($file, strlen(DIRECTORY_SEPARATOR), strlen($file));
		}

		// return the filename
		return $file;
	}

	/**
	 * Register all autoloader methods with Standard-PHP-Library
	 *
	 * @return		boolean
	 */
	private function _register() {
		$reflection = new \ReflectionClass($this);
		foreach ($reflection->getMethods() as $method) {
			$name = $method->name;
			if (!in_array($name, $this->_noLoaderMethods)) {
				// register the method
				spl_autoload_register(array($this, $name));
			}
		}

		return true;
	}









	/**
	 * Autoloader Methods
	 */

	/**
	 * Autoloader for the Cwa Framework classes
	 *
	 * @param		String		Classname with complete namespace
	 * @return		boolean
	 */
	public function Spaf($name) {
		$file = $this->_getFilename($name);
		$file = '../' . $file;
		if ($this->_debug === true) {
			echo $file . "\n";
		}

		if (is_file($file) && is_readable($file)) {
			// do debug message if needed
			if ($this->_debug === true) {
				echo '<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' successfully loaded' . "<br />\n";
			}
			// require the file
			require_once($file);
			return true;
		} else {
			if ($this->_debug === true) {
				echo '<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' not found; include_path:' . get_include_path() . "<br />\n";
			}
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
		if ($this->_debug === true) {
			echo $file . "\n";
		}
		if (is_file($file) && is_readable($file)) {
			// do debug message if needed
			if ($this->_debug === true) {
				echo '<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' successfully loaded' . "<br />\n";
			}
			// require the file
			require_once($file);
			return true;
		} else {
			if ($this->_debug === true) {
				echo '<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' not found; include_path:' . get_include_path() . "<br />\n";
			}
		}
	}
}
?>