<?php

/**
 * $Id$
 *
 * Spaf/Core/Request/Php.php
 * @created Tue Jun 10 16:23:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Request;

/**
 * \Spaf\Core\Request\Php
 *
 * The class for handling php connections.
 * You might use this class in PHP-GTK environment
 * but also in Web if you are doing some calls from
 * a php controller in some views
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Request
 * @namespace \Spaf\Core\Request
 */
class Php extends Http {
	
	/**
	 * Set a param is basicly not good in http.
	 * We still offer functionality since it works great
	 * and was the easiest solution for offering this 
	 * Php Request without building almost everthing double.
	 * 
	 * @param string Name for the key
	 * @param string Value itself, it has to be a string since HTTP is only supporting strings
	 * @return boolean true
	 */
	public function setParam($name, $value) {
		$_REQUEST[$name] = $value;
		
		return true;
	}
	
	/**
	 * Shortcut for self::setParam
	 * 
	 * @see \Spaf\Core\Request\Php::setParam()
	 */
	public function set($name, $value) {
		return $this->setParam($name, $value);	
	}

}

?>