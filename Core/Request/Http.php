<?php

/**
 * $Id$
 *
 * Spaf/Core/Request/Http.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Request;

/**
 * \Spaf\Core\Request\Http
 *
 * The class for handling http connections.
 * You might most of the time use this class
 * in web environment. This is used for ajax calls as well
 *
 * @author Claudio Walser
 * @package \Spaf\Core\Request
 * @namespace \Spaf\Core\Request
 */
class Http extends Abstraction {
	
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
	 * @return string Value of the given key or the default value if nothing found
	 */
	public function getParam($name, $default = null) {
		return isset($_REQUEST[$name]) ? $this->_dispatchParam($_REQUEST[$name]) : $default;
	}

	/**
	 * Shortcut for self::getParam
	 * 
	 * @see \Spaf\Core\Request\Http::getParam()
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
		$l = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$l = substr($l, 0, 5);
		$p = explode('-', $l);
		if (is_array($p)) {
			return $p[0] . '_' . strtoupper($p[1]);
		}
		
		return null;
	}	
	
	/**
	 * Get one element from $_FILES by key
	 * 
	 * @param string Name of the key
	 * @return array Array with upload information from $_FILES
	 */
	public function getUpload($name) {
		if (isset($_FILES[$name]) && $this->_utf8Decode === true) {
			$_FILES[$name]['name'] = utf8_decode($_FILES[$name]['name']);
		}
		
		return isset($_FILES[$name]) ? $_FILES[$name] : null;
	}
	
	/**
	 * Get the client ip if possible.
	 * If nothing is found, you will get NULL
	 * as return value.
	 * 
	 * @return mixed Client IP or NULL if nothing found
	 */
	public function getIp() {
		$ip = null;
		if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if(getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		 }else if(getenv("REMOTE_ADDR")) {
			$ip = getenv("REMOTE_ADDR");
		}
		return $ip;
	}
	
	/**
	 * Resets the whole reqeust stuff
	 * 
	 * @return boolean true
	 */
	public function reset() {
		$_GET = array();
		$_POST = array();
		$_REQUEST = array();
		$_FILES = array();
		
		return true;
	}
	
	/**
	 * Returns all Values from $_REQUEST as an array.
	 * 
	 * @return array The $_REQUEST Array
	 */
	private function _getAllRequestVariables() {
		return isset($_REQUEST) ? $this->_dispatchParam($_REQUEST) : array();
	}
	
	/**
	 * Returns all Values from $_FILES as an array.
	 * 
	 * @return array The $_FILES Array
	 */
	private function _getAllUploads() {
		$files = array();
		if (!isset($_FILES) && is_array($_FILES)) {
			foreach ($_FILES as $key => $file ) {
				$files[$key] = $this->getUpload($key);
			}
		}
		
		return $files;
	}
	
	/**
	 * Dispath one value.
	 * This method is using utf8_decode if you asked for it.
	 * 
	 * @param string Dirty value
	 * @return mixed Dispatched and clean value
	 */
 	private function _dispatchParam($var) {
		// for arrays
		if (is_array($var)) {
			// make it recursive
			foreach ($var as $key => $value) {
				$var[$key] = $this->_dispatchParam($value);
			}
			if (empty($var)) {
				$var = '';
			}
		// for strings
		} else {
			// just handle it
			$var = (string) $var;
			$var = trim($var);
			// utf8 decode if you asked for it
			if ($this->_utf8Decode === true) {
				$var = utf8_decode($var);
			}
		}
		
		return $var;
	}
	
}

?>