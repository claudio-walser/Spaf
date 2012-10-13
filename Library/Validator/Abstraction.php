<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Abstraction.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Abstraction
 *
 * Abstract validation class, any concrete
 * validator has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Abstraction {

	/**
	 * Value to validate
	 */
	protected $_value = null;

	/**
	 * Min Length of a value
	 *
	 * @var integer
	 */
	protected $_minLength = null;

	/**
	 * Max Length of a value
	 *
	 * @var integer
	 */
	protected $_maxLength = null;

	/**
	 * Constructor is taking a value and creates the validator object
	 *
	 * @param mixed Value to validate
	 */
	public function __construct($value) {
		$this->setValue($value);
	}

	/**
	 * Set a value after construction
	 *
	 * @param mixed Value to validate
	 * @return boolean True
	 */
	public function setValue($value) {
		$this->_value = $value;

		return true;
	}

	/**
	 * Set min length
	 *
	 * @param integer Min Length
	 * @return boolean True
	 */
	public function setMinLength($length) {
		$this->_minLength = $length;
	}

	/**
	 * Set max length
	 *
	 * @param integer Max Length
	 * @return boolean True
	 */
	public function setMaxLength($length) {
		$this->_maxLength = $length;
	}

	/**
	 * Validate function itself
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
		return true;
	}

}

?>