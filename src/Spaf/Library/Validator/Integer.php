<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Integer.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Integer
 *
 * Integer validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Integer extends AbstractValidator {

	/**
	 * Simple check, if a value is numeric
	 * its supposed to be an integer for
	 * this validation.
	 *
	 * @return boolean True if the value is numeric
	 */
	public function validate() {
		return is_numeric($this->_value);
	}
}

?>