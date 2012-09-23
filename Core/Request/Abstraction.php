<?php

/**
 * $Id$
 *
 * Spaf/Core/Request/Abstraction.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Request;

/**
 * \Spaf\Core\Request\Abstraction
 *
 * Thats a base request classe.
 * Any concrete request should extend this class.
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Request
 * @namespace \Spaf\Core\Request
 * @abstract
 */
abstract class Abstraction {
	
	/**
	 * Either this class should utf8 decode incoming values or not
	 * 
	 * @var boolean True if incoming values should be handled with utf8_decode
	 */
	protected $_utf8Decode = false;
	
	/**
	 * Abstract function getParams should be implemented by
	 * any child class. This should return all sent params by array.
	 * 
	 * @return array All sent params as array
	 */
	abstract function getParams();
	
	/**
	 * Abstract function getParam should be implemented by
	 * any child class. This should return one param asked by key.
	 * You can pass a default value what is returned if no key is found.
	 * 
	 * @param string Name of the key
	 * @param mixed Default value to be returned
	 * @return mixed Value asked by param
	 */
	abstract function getParam($name, $default = null);
	
	/**
	 * Abstract function getFile should be implemented by
	 * any child class which is supporting file uploads. 
	 * This should return one param asked by key.
	 * 
	 * @param string Name of the key
	 * @return mixed Uploaded File asked by param
	 */
	abstract function getUpload($name);
	
	/**
	 * For some kind of request classes it might be usefull to set values as well.
	 * Usually, as for http requests, this is not the case.
	 * In kind of just doing some PHP-Gtk to DSL connections,
	 * it might be very usefull.
	 * 
	 * @param string Name for the key
	 * @param mixed The value itself
	 * @return boolean true
	 */
	public function setParam($name, $value) {
		// basicly it does nothing
		return true;
	}
	
	/**
	 * Set the internal value of utf8Decode.
	 * 
	 * @param boolean True if you want to handle inputs with utf8_decode
	 * @return boolean true
	 */
	public function setUtf8Decode($bool) {
		$this->_utf8Decode = (bool) $bool;
		
		return true;
	}

	/**
	 * Get the internal value of utf8Decode.
	 * 
	 * @return boolean The value of utf8Decode
	 */
	public function setUtf8Decode() {
		return $this->_utf8Decode;
	}

}

?>