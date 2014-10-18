<?php

/**
 * $Id$
 *
 * Spaf/Core/Request/AbstractRequest.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Request;

/**
 * \Spaf\Core\Request\AbstractRequest
 *
 * Thats a base request class.
 * Any concrete request should extend this class.
 *
 * @author Claudio Walser
 * @package Spaf\Core\Request
 * @namespace Spaf\Core\Request
 * @abstract
 */
abstract class AbstractRequest {

	protected $_params = array();
	
	protected $_files = array();

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

}

?>