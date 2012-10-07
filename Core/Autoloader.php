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
 * @package \Spaf\Core
 * @namespace \Spaf\Core
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
	 * Methods which are no autoloader
	 *
	 * @var array
	 */
	private $_noLoaderMethods = array('__construct', 'setDebug', '_getFilename', '_register');

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

}

?>
