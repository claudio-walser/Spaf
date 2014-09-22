<?php

/**
 * $Id$
 *
 * Spaf/Core/Response/Php.php
 * @created Tue Jun 10 16:20:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Core\Response;

/**
 * \Spaf\Core\Response\Php
 *
 * The class for handling php responses.
 * Usefull to responding to PHP-GTK calls or any other
 * calls from a php view.
 *
 * @author Claudio Walser
 * @package Spaf\Core\Response
 * @namespace Spaf\Core\Response
 */
class Php extends Abstraction {

	/**
	 * What values should result in ['success'] = false?
	 *
	 * @var array Small config array of what values should result in success => false
	 */
	private $_false = array(false, null, 0, '');

	/**
	 * Just returns the values.
	 * This is ALWAYS outputting an array like the following
	 * array(
	 * 		success => true || false
	 * 		data => the gifen $param
	 * 		count => amount of $param or your given value if not null
	 * )
	 * If you dont want all these informations, just pass $pure=true as fourth parameter.
	 *
	 * @param mixed Your return value
	 * @param int Number of all rows if you use paging
	 * @param boolean Give a fixed success value if you want to return NULL explicit for example
	 * @param boolean Pass true if you want to return the pure data without success and count values
	 * @return true
	 */
	public function write($param, $count = null, $success = null, $pure = false) {
		// if pure, just return
		if ($pure === true) {
			return $this->_encodeUtf8 === true ? $this->_utf8Encode($param) : $param;
		}

		// init $out as array
		$out = array();
		// set success on true per default
		$out['success'] = $success !== null ? $success : true;
		if ($success !== null) {
			$out['success'] = $success;
		} else {
			// return success false if any other than a array or something is coming
			foreach ($this->_false as $false) {
				if ($false === $param) {
					$out['success'] = false;
				}
			}
		}
		// if success not equals false
		if ($out['success'] !== false || (isset($success) && $success !== null)) {
			// put data in $out['data']
			$out['data'] = $this->_encodeUtf8 === true ? $this->_utf8Encode($param) : $param;
			$out['count'] = $count === null ? count($out['data']) : $count;
		}

		return $out;
	}

	/**
	 * Encodes a array or simple string to utf8 charset, other types are ignored.
	 *
	 * @param mixed The value you want to UTF8 encode
	 * @return mixed UTF8 encoded value you passed as param
	 */
	private function _utf8Encode($param) {
		if (!is_array($param)) {
			if (is_string($param)) {
				return utf8_encode($param);
			} else {
				return $param;
			}
		} else {
			foreach ($param as $key => $value) {
				$param[$key] = $this->_utf8Encode($value);
			}
		}

		return $param;
	}

}

?>