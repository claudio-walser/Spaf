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

class Email extends Abstraction {

	/**
	 * Top level domains, set some if you want to limit
	 * Default to null means no validation on top level domain
	 *
	 * @var array Array with allowed top level domains
	 * @return boolean True
	 */
	private $_tlds = null;

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
	 * Set an array of top level domains to limit.
	 *
	 * @param array TLD for setting up the limitations
	 * @return boolean True
	 */
	public function setTopLevelDomains(array $tlds) {
		$this->_tlds = $tlds;

		return true;
	}

	/**
	 * Overwrite validate function.
	 * Lenght stuff is not usefull for emails.
	 *
	 * @return boolean True or false depends on validation
	 */
	public function validate() {
		// first split by @
		$parts = explode('@', $this->_value);
		// false if more than two parts
		if (count($parts) > 2) {
			return false;
		}

		// save user and hostname
		$user = $parts[0];
		$hostname = $parts[1];

		// split hostname again by dot
		$parts = explode('.', $hostname);
		// false if less than two parts
		if (count($parts) < 2) {
			return false;
		}

		// save tld and host
		$tld = array_pop($parts);
		$host = implode('.', $parts);

		// if any tld limitations set
		if ($this->_tlds !== null) {
			if (!in_array($tld, $this->_tlds)) {
				return false;
			}
		}

		// if mx validation is set
		if ($this->_useMxValidation === true) {
			$mxSuccess = getmxrr ($hostname, $mxhosts);
			if (!is_array($mxhosts) || count($mxhosts) < 1) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @todo Maybe add a more reliable but still fast regex version useable without mx validaton, which is slow
	 */

}

?>