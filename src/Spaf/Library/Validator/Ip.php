<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Ip.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Ip
 *
 * Ip validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Ip extends AbstractValidator {

	/**
	 * Allow wildcard * in validation as well
	 * default to false.
	 *
	 * @var boolean
	 */
	private $_allowWildcards = false;

	/**
	 * Set allow wildcards to true.
	 * If set, wildcard * is allowed as well
	 *
	 * @param boolean True for using wildcard *
	 * @return boolean True
	 */
	public function useWildcards($bool) {
		$this->_allowWildcards = (bool) $bool;

		return true;
	}

	/**
	 * Simple ip validation.
	 * Splits by dot, checks on four elements
	 * and if each element is between 0 and 255.
	 *
	 * @todo Not quite sure yet if in_array might be slow with that much elements
	 * @return boolean True or false
	 */
	public function validate() {
		$numbers = explode('.', $this->_value);
		if (count($numbers) !== 4) {

			return false;
		}

		$range = range(0, 255);

		if ($this->_allowWildcards === true) {
			$range[] = '*';
		}

		foreach ($numbers as $number) {
			// check range
			if (!in_array($number, $range)) {
				return false;
			}
		}

		return true;
	}

}

?>