<?php
/**
 * $Id$
 * Registry class
 *
 * @created 	Tue Jun 08 19:26:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Core
 * @namespace	\Cwa\Core
 */

namespace Cwa\Core;


/**
 * \Cwa\Core\Registry
 *
 * The Registry class implementes the singleton pattern
 * in order to be availible as simple as possible in all
 * other tiers.
 *
 * @author 		Claudio Walser
 * @abstract
 */
class Registry {
	
	/**
	 * Private instacne because of singleton implementation
	 *
	 * @var
	 */
	private static $_instance 	= null;
	
	private $_objects 			= array();
	
	private $_persistent 		= array();
	

	private function __construct() {}
	private function __clone() {}
	
	
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new Registry();
		}
		return self::$_instance;
	}
	
	
	public function set($name, $object, $persistent = false) {
		
		if (!is_object($object)) {
			throw new Exception('Cwa\Core\Registry only store PHP-objects');
		}
	
		if ($persistent !== true) {
			$persistent = false;
		}
		
		if (isset($this->_persistent[$name]) && $this->_persistent[$name] === true) {
			throw new Exception('Try to overwrite persistent object: ' . $name);
		}
		
		$this->_objects[$name] 		= $object;
		$this->_persistent[$name] 	= $persistent;
		return true;
	}
	
	
	public function get($name, $veryImportant = false) {
		$obj =  isset($this->_objects[$name]) ? $this->_objects[$name] : null;
		if ($obj === null && $veryImportant === true) {
			throw new Exception('Object ' . $name . ' cannot be found');	
		}
		return $obj;
	}
}


?>