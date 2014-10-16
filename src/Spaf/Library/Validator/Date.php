<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/Date.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\Date
 *
 * Date validation class,
 * just able to validate Y-m-d and d.m.Y yet
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class Date extends AbstractValidator {

	/**
	 * Current format to validate
	 *
	 * @var string
	 */
	private $_format = 'Y-m-d';

	/**
	 * Set a format you want to validate with
	 * It should basicly work with any format described in
	 * http://www.php.net/manual/en/function.date.php
	 *
	 * @param string Format you want to validate with
	 * @return boolean True, or false if you try to set an invalid format
	 */
	public function setFormat($format) {
		$this->_format = $format;

		return true;
	}

	/**
	 * The array validator cannot use
	 * parents validation since its working with Date
	 * instead of scalars.
	 *
	 * @return boolean Returns the validation result
	 */
	public function validate() {
		return date($this->_format, strtotime($this->_value)) === $this->_value;
	}

}

?>