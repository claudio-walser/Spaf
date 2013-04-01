<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Url.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Abstraction
 *
 * Url validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Url extends Abstraction {

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
	 * the hostname/ip of this address.
	 * Note this might take some time, since
	 * its starting a dns request over the network.
	 *
	 * @var boolean
	 */
	private $_useDnsValidation = false;

	/**
	 * Set dns validation to true or false.
	 * Note this might take some time, since
	 * its starting a dns request over the network.
	 *
	 * @param boolean True or false, wheter if you want to use dns validation or not
	 */
	public function useDnsValidation($bool) {
		$this->_useDnsValidation = (bool) $bool;
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
	 * Lenght stuff is not usefull for Urls.
	 *
	 * @return boolean True or false depends on validation
	 */
	public function validate() {
		$parts = $this->_splitUrl($this->_value);
		if (!is_array($parts)) {
			return false;
		}
		// save tld and host
		$tld = $parts['tld'];
		$host = $parts['host'];

		// if any tld limitations set
		if ($this->_tlds !== null) {
			if (!in_array($tld, $this->_tlds)) {
				return false;
			}
		}

		// if dns validation is set
		if ($this->_useDnsValidation === true) {
			$ip = gethostbyname($this->_value);
			if ($ip === $this->_value) {
				return false;
			}
			$validator = new Ip($ip);
			if ($validator->validate() === false) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Splits a url into top level domain and host
	 *
	 * @param string Url to split
	 * @return mixed False if no real url given
	 */
	protected function _splitUrl($url) {
		// split hostname again by dot
		$parts = explode('.', $url);
		// false if less than two parts
		if (count($parts) < 2) {
			return false;
		}

		$tld = array_pop($parts);

		return array('host' => implode('.', $parts), 'tld' => $tld);
	}

	/**
	 * @todo Maybe add a more reliable but still fast regex version useable without dns validaton, which is slow
	 */

}

?>