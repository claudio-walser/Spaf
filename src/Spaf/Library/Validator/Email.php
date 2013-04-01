<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Email.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Abstraction
 *
 * Email validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Email extends Url {

	/**
	 * Set to true if you wish to validate
	 * the hostname of this address has one
	 * mx entry at least.
	 * Note this might take some time, since
	 * its starting a dns request over the network.
	 *
	 * @var boolean
	 */
	private $_useMxValidation = false;

	/**
	 * Set mx validation to true or false.
	 * Note this might take some time, since
	 * its starting a dns request over the network.
	 *
	 * @param boolean True or false, wheter if you want to use mx validation or not
	 */
	public function useMxValidation($bool) {
		$this->_useMxValidation = (bool) $bool;
	}

	/**
	 * Overwrite validate function.
	 * Lenght stuff is not usefull for emails.
	 *
	 * @return boolean True or false depends on validation
	 */
	public function validate() {
		$parts = $this->_splitEmail($this->_value);
		if (!is_array($parts)) {
			return false;
		}
		// save user and hostname
		$user = $parts['user'];
		$host = $parts['host'];

		$validUrl = $this->_parentValidation($host);

		if ($validUrl === false) {
			return false;
		}

		// if mx validation is set
		if ($this->_useMxValidation === true) {
			$mxSuccess = getmxrr ($host, $mxhosts);
			if (!is_array($mxhosts) || count($mxhosts) < 1) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Call parents Url::validate
	 * Therefore set $_value temporary with the host only
	 * call parent and set it back to the email value.
	 *
	 * @param string Hostname to check with parent
	 * @return boolean True or false depending to Url::validate
	 */
	private function _parentValidation($host) {
		// store old
		$emailValue = $this->_value;
		// set host to current value for parent Url::validate
		$this->_value = $host;
		// call url validation on host
		$parentValidation = parent::validate();
		// set email value back
		$this->_value = $emailValue;

		// return parent
		return $parentValidation;
	}

	/**
	 * Splits a email into user and host
	 *
	 * @param string Email to split
	 * @return mixed False if no real email given
	 */
	private function _splitEmail($email) {
		$parts = explode('@', $email);
		// false if more than two parts
		if (count($parts) !== 2) {
			return false;
		}

		return array('user' => $parts[0], 'host' => $parts[1]);
	}

	/**
	 * @todo Maybe add a more reliable but still fast regex version useable without mx validaton, which is slow
	 */

}

?>