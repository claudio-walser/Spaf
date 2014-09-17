<?php

/**
 * $Id$
 *
 * Spaf/Core/Autoloader.php
 * @created Tue Jun 10 19:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core;

/**
 * \Spaf\Core\Autoloader
 *
 * Thats a base controller classe.
 * Any concrete controller should extend this class.
 *
 * @author Claudio Walser
 * @package Spaf\Core
 * @namespace Spaf\Core
 * @abstract
 */
class Autoloader {

	/**
	 * Debugging true or false
	 *
	 * @var bool
	 */
	private $_debug = true;

	/**
	 * Paths to lookup for php classes, additional to include_path in php.ini
	 *
	 * @var array
	 */
	protected $_lookupPaths = array(
		'./'
	);

	/**
	 * Pass the given debug param and register
	 * needed functions.
	 *
	 * @param boolean True to see some usefull debug outputs
	 */
	public function __construct($debug = false) {
		$this->setDebug($debug);
		$this->_register();
	}

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

	/**
	 * Outputting a string, respecting the internal $_debug value.
	 *
	 * @param string String to debug
	 * @return boolean Current debug setting. True for debug is currently active
	 */
	public function debug($string) {
		if ($this->_debug === true) {
			echo $string;
		}

		return $this->_debug;
	}

	/**
	 * Get filename of a class, splitted by
	 * given separator.
	 *
	 * @param string Classname
	 * @param sring Used Separator, most usually its "\\" for php >= 5.3 and "_" for php < 5.3
	 * @return string Evaluated filename
	 */
	protected function _getFilename($class, $separator = '\\') {
		// get the file path from namespace and classname
		$file = str_replace($separator, DIRECTORY_SEPARATOR, $class) . '.php';

		// remove first slash
		if (substr($file, 0, strlen(DIRECTORY_SEPARATOR)) === DIRECTORY_SEPARATOR) {
			$file = substr($file, strlen(DIRECTORY_SEPARATOR), strlen($file));
		}

		// return the filename
		return $file;
	}

	private function _loadClasses($name) {
		$fileName = $this->_getFilename($name);
		foreach ($this->_lookupPaths as $path) {
			$file = $path . $fileName;
			if (is_file($file) && is_readable($file)) {
				// do debug message if needed
				$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- File ' . $file . ' successfully loaded' . "<br />\n");
				// require the file
				require_once($file);
				
				return true;
			}
		}
		$this->debug('<strong>' . date('Y-m-d H:i:s') . '</strong> -- Class ' . $fileName . ' not found; autoload lookup paths: ' . print_r($this->_lookupPaths, true) . ' include_path:' . get_include_path() . "<br />\n");
		
		return false;
	}

	/**
	 * Register all autoloader methods with Standard-PHP-Library
	 *
	 * @return		boolean
	 */
	private function _register() {
		spl_autoload_register(array($this, '_loadClasses'));


		return true;
	}

}

?>