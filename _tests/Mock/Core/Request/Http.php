<?php

/**
 * $Id$
 *
 * Spaf/_tests/Mock/Core/Request/Http.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\_tests\Mock\Core\Request;

/**
 * \Spaf\_tests\Mock\Core\Response\Http
 *
 * Http Response Mock
 *
 * @author Claudio Walser
 * @package Spaf\_tests\Mock\Core\Request
 * @namespace Spaf\_tests\Mock\Core\Request
 * @abstract
 */
class Http extends \Spaf\Core\Request\Http {

	/**
	 * Just return the whole request array.
	 * File uploads are included as well.
	 *
	 * @return array Array with all request and file-upload values
	 */
	public function getParams() {
		return array('request' => $this->_getAllRequestVariables(), 'files' => $this->_getAllUploads());
	}

	/**
	 * Get one param by name.
	 *
	 * @param string Name of the key
	 * @param mixed Default value to return if there is no value with the given key
	 * @return string The mock is always returning the given default value
	 */
	public function getParam($name, $default = null) {
		return $default;
	}

	/**
	 * Shortcut for self::getParam
	 *
	 * @see \Spaf\Core\Request\Http::getParam()
	 * @param string Keyname
	 * @param mixed Default value to return if nothing found
	 */
	public function get($name, $default = null) {
		return $this->getParam($name, $default);
	}

	/**
	 * Try to fetch the client language.
	 * If nothing usefull found, you will get NULL
	 * as return value.
	 *
	 * @return mixed Client Language as string or NULL if nothing found
	 */
	public function getClientLanguage() {
		return 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4';
	}

	/**
	 * Get one element from $_FILES by key
	 *
	 * @param string Name of the key
	 * @return array Array with upload information from $_FILES
	 */
	public function getUpload($name) {
		return null;
	}

	/**
	 * Get the client ip if possible.
	 * If nothing is found, you will get NULL
	 * as return value.
	 *
	 * @return mixed Client IP or NULL if nothing found
	 */
	public function getIp() {
		return '127.0.0.1';
	}

	/**
	 * Resets the whole reqeust stuff
	 *
	 * @return boolean true
	 */
	public function reset() {
		return true;
	}

	/**
	 * Returns all Values from $_REQUEST as an array.
	 *
	 * @return array The $_REQUEST Array
	 */
	private function _getAllRequestVariables() {
		return array();
	}

	/**
	 * Returns all Values from $_FILES as an array.
	 *
	 * @return array The $_FILES Array
	 */
	private function _getAllUploads() {
		return array();
	}

	/**
	 * Dispath one value.
	 * This method is using utf8_decode if you asked for it.
	 *
	 * @param string Dirty value
	 * @return mixed Dispatched and clean value
	 */
 	private function _dispatchParam($var) {
		return $var;
	}

}

?>