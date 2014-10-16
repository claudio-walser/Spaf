<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/AbstractValidator.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\AbstractValidator
 *
 * Abstract validation class, any concrete
 * validator has to extend this
 *
 * @todo Maybe a session validator for proof of session-hijacking
 * @todo Implement something for setting and fetching a error message for what currently went wrong
 * @todo Implement something for convert input to a valid value. Maybe usefull for guessing something in a form input
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

abstract class AbstractValidator {

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
	 * Constructor is taking a value and creates the validator object
	 *
	 * @param mixed Value to validate
	 */
	public function __construct($value) {
		$this->setValue($value);
	}

	/**
	 * Set a value after construction
	 * You most probably want to overwrite this
	 * in any child class for doing
	 * type hinting or maybe type casting or any other initial
	 * operation.
	 *
	 * @param mixed Value to validate
	 * @return boolean True
	 */
	public function setValue($value) {
		$this->_value = $value;

		return true;
	}

	/**
	 * Get the value. Note setValue most probably does
	 * a type casting on it, so maybe you wont get back
	 * the exact same value as you set.
	 *
	 * @return mixed Value
	 */
	public function getValue() {
		return $this->_value;
	}

	/**
	 * Get a guess from validator class
	 * Might be usefull in case of email or url validation.
	 * Might be not usefull at all :p
	 *
	 * @return mixed Guess what the given value could mean
	 */
	public function getGuess() {
		return $this->_value;
	}

	/**
	 * Validate function itself
	 *
	 * @return boolean Returns the validation result
	 */
	abstract public function validate();

}

?>