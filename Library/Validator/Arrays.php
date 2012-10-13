<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Arrays.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Arrays
 *
 * Array validation class
 *
 * PHP sometimes i seriously hate you,
 * why can i not write class Array but
 * String, Date, File and anything, but not Array?
 * I understand i cannot use Static|Abstract or even Class
 * as class name, but Array? Come on...
 * Not sure if i should write a feature request or bug ticket :-P
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Arrays extends Abstraction {

	/**
	 * Just overwrite it for doint type hinting
	 *
	 * @param array Array to validate
	 */
	public function setValue(array $array) {
		parent::setValue($array);
	}

	/**
	 * The array validator cannot use
	 * parents validation since its working with arrays
	 * instead of scalars.
	 *
	 * @return boolean Returns the validation result
	 */
	public function validate() {
		// if no value is set, throw an exeception
		if ($this->_value === null) {
			throw new Exception('Doesent make any sense to validate something without setting a value first.');
		}

		// chekck min length
		if ($this->_minLength !== null) {
			if (count($this->_value) < $this->_minLength) {
				return false;
			}
		}

		// check max length
		if ($this->_maxLength !== null) {
			if (count($this->_value) > $this->_maxLength) {
				return false;
			}
		}

		// return true
		return true;
	}

}

?>