<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/String.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\String
 *
 * String validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class String extends Abstraction {

	/**
	 * Validate function itself
	 *
	 * @return boolean Returns the validation result
	 */
	public function validate() {

		// chekck min length
		if ($this->_minLength !== null) {
			if (strlen($this->_value) < $this->_minLength) {
				return false;
			}
		}

		// check max length
		if ($this->_maxLength !== null) {
			if (strlen($this->_value) > $this->_maxLength) {
				return false;
			}
		}

		// return true
		return is_string($this->_value);
	}

}

?>