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
class Php extends AbstractResponse {

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
			return $param;
		}

		// init $out as array
		$out = array();
		// set success on true per default
		$out['success'] = $success !== null ? (bool) $success : true;
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
			$out['data'] = $param;
			$out['count'] = $count === null ? count($out['data']) : $count;
		}

		return $out;
	}

}

?>