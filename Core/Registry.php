<?php

/**
 * $Id$
 *
 * Registry.php
 * @created Tue Jun 08 19:26:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core;

/**
 * \Spaf\Core\Registry
 *
 * The Registry class implementes the singleton pattern
 * in order to be availible as simple as possible in all
 * other tiers.
 *
 * @author Claudio Walser
 * @package \Spaf\Core
 * @namespace \Spaf\Core
 */
class Registry {

	/**
	 * Private instacne because of singleton implementation
	 *
	 * @var
	 */
	private static $_instance = null;
	
	/**
	 * Objects container
	 * 
	 * @var array
	 */
	private $_objects = array();
	
	/**
	 * Persistent informations
	 * 
	 * @var array
	 */
	private $_persistent = array();
	
	/**
	 * Private methods for beeing singleton
	 */
	private function __construct() {}
	private function __clone() {}
	
	/**
	 * Method for getting instance
	 * For mocking this class, you can inject your own instance
	 * at any time.
	 * 
	 * @param \Spaf\Core\Registry Registry class to inject, default to null
	 * @return \Spaf\Core\Registry
	 */
	public static function getInstance(\Spaf\Core\Registry $registry = null) {
		// set injected registry
		if ($registry !== null) {
			self::$_instance = $registry;
		}
		
		// 
		if (self::$_instance === null) {
			self::$_instance = new Registry();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Push an object to the registry.
	 * Basicly its a key value method, the third parameter is
	 * to store the object persistent and dont allow overwrites.
	 * 
	 * @throws \Spaf\Core\Exception Throws an Exception if you try to set anything but an object
	 * @throws \Spaf\Core\Exception Throws an Exception if you try to overwrite a persistent object
	 * 
	 * @param string Name for the key
	 * @param Object Any php object to story
	 * @param boolean True for set an object persistent, default to false
	 * @return boolean true 
	 */
	public function set($name, $object, $persistent = false) {
		// throws an exeption if you try to set anything but an object
		if (!is_object($object)) {
			throw new Exception(get_class($this) . ': You can only store php objects');
		}
		
		// not just type cast, everything but true is meant to false
		if ($persistent !== true) {
			$persistent = false;
		}
		
		// throws a \Spaf\Core\Exception if you try to overwrite a persistent object
		if (isset($this->_persistent[$name]) && $this->_persistent[$name] === true) {
			throw new Exception(get_class($this) . ': You try to overwrite the persistent object with key "' . $name . '"');
		}
		
		// put to store
		$this->_objects[$name] 		= $object;
		$this->_persistent[$name] 	= $persistent;
		
		return true;
	}
	
	/**
	 * Get an object from the registry
	 * 
	 * @throws Throws an \Spaf\Core\Exception if a value cannot be found and you passed the veryImportant param as true
	 * 
	 * @param string Key-Name for the object
	 * @param boolean True for throwing an Exception if the value cannot be found
	 */
	public function get($name, $veryImportant = false) {
		$obj =  isset($this->_objects[$name]) ? $this->_objects[$name] : null;
		if ($obj === null && $veryImportant === true) {
			throw new Exception(get_class($this) . ': Object with key "' . $name . '" cannot be found');	
		}
		
		return $obj;
	}

}

?>