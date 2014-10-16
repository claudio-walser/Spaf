<?php

/**
 * $ID$
 *
 * Spaf/Library/Validator/File.php
 * @create Sat Oct 13 21:49:41 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Validator;


/**
 * \Spaf\Library\Validator\File
 *
 * File validation class
 *
 * @author Claudio Walser
 * @package Spaf\Library\Validator
 * @namespace Spaf\Library\Validator
 */

class File extends AbstractValidator {

	/**
	 * Maximal file size in bytes.
	 * Default to null which means no limit
	 *
	 * @var int
	 */
	private $_maxSize = null;


	/**
	 * MD5 Hash for file validation
	 *
	 * @var string
	 */
	private $_md5 = null;

	/**
	 * Set max file size for validation.
	 *
	 * @param int Max file size in byte
	 * @return boolean True
	 */
	public function setMaxSize($size) {
		$this->_maxSize = (int) $size;

		return true;
	}

	/**
	 * Set max file size for validation.
	 *
	 * @param int Max file size in byte
	 * @return boolean True
	 */
	public function setMd5($md5) {
		$this->_md5 = (string) $md5;

		return true;
	}

	/**
	 * Validate function itself, checks eventually on file size
	 * and md5 hasch of the file if given.
	 *
	 * @return boolean True or false based on validation inputs
	 */
	public function validate() {
		// always create a file object, this is throwing an exception on non existent files already
		$file = new \Spaf\Library\Directory\File($this->_value);

		// file size
		if ($this->_maxSize !== null) {
			if ($file->getSize() > $this->_maxSize) {
				return false;
			}
		}

		// file hash
		if ($this->_md5 !== null) {
			if ($file->getMd5() !== $this->_md5) {
				return false;
			}
		}

		return true;
	}

}

?>