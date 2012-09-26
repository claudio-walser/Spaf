<?php

/**
 * $Id$
 *
 * Spaf/Library/Autoloader.php
 * @created Tue Jun 10 19:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library;

/**
 * \Spaf\Library\Autoloader
 *
 * Thats a base controller classe.
 * Any concrete controller should extend this class.
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Controller
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
	
	public function debug($string) {
		if ($this->_debug === true) {
			echo $string;
		}
		
		return $this->_debug;
	}
	
	
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