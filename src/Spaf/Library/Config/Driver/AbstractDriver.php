<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Driver/AbstractDriver.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\AbstractDriver
 *
 * This is the abstract basic
 * driver class. Any concrete config driver
 * has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
abstract class AbstractDriver {

	protected $_unconvertableRead = false;
	protected $_unconvertableWrite = false;

	/**
	 * Source file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_sourceFile = null;

	/**
	 * Value map to convert some php special values.
	 * The value its meant as the real value, its key is written to the config files.
	 * For some strange reason, its completly not working with the 'null' key, the value is recognized but i got problems with the key...
	 *
	 * @var array
	 */
	protected $_valueMap = array(
		'true' => true,
		'false' => false,
		'null', null
	);

	/**
	 * _read has to be implemented in any driver.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Config Array
	 */
	abstract protected function _read(\Spaf\Library\Directory\File $file);

	/**
	 * _write has to be implemented by any driver.
	 *
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	abstract protected function _write($array, \Spaf\Library\Directory\File $file);

	/**
	 * Set the source file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean True
	 */
	public function setSourceFile(\Spaf\Library\Directory\File $file) {
		$this->_sourceFile = $file;

		return true;
	}

	final public function read() {
		// check source file
		if ($this->_sourceFile === null) {
			throw new Exception('no source file set to read from');
		}

		// read from driver
		$array = $this->_read($this->_sourceFile);

		// handle types
		$array = $this->_handleTypes($array, 'read');

		return $array;
	}

	final public function write($array) {
		// check source file
		if ($this->_sourceFile === null) {
			throw new Exception('no source file set to write into');
		}

		// handle types
		$array = $this->_handleTypes($array, 'write');

		// write with driver
		$success = $this->_write($array, $this->_sourceFile);

		return $success;
	}

	/**
	 * Read a single value, means in first case,
	 * type cast to integer|float|string|boolean|null
	 *
	 * @param string Raw value
	 * @return mixed Type casted value
	 */
	private function _readValue($value) {
		if ($this->_unconvertableRead !== false) {
			return $value;
		}

		// handle null special, cause its not working with the valueMap
		if ($value === 'null') {
			return null;
		}

		// everything else from the value map
		foreach ($this->_valueMap as $key => $val) {
			if ($value === $key || $value === strtoupper($key)) {
				return $val;
			}
		}

		// type cast float and integer
		if (is_numeric($value)) {
			if (strpos($value, '.')) {
				$value = (float) $value;
			} else {
				$value = (int) $value;
			}
		}

		return $value;
	}

	/**
	 * Convert different types to its writable value
	 *
	 * @param mixed Typed value
	 * @param string Its writable value
	 */
	private function _writeValue($value) {
		if ($this->_unconvertableWrite !== false) {
			return $value;
		}
		// not quite sure why, $key its returning int(1) here???, this small hack works as expected
		// stuff like that did not happen in a strong typed language :-P
		if ($value === null) {
			return 'null';
		}

		// since it seems php array functions has problems with such values, lets do by our own
		foreach ($this->_valueMap as $key => $val) {
			if ($val === $value || $val === strtolower($value)) {
				return $key;
			}
		}

		return $value;
	}

	protected function _handleTypes(array $array, $type = 'read') {
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				throw new Exception('Config input isnt a two dimensional array');
			}

			foreach ($value as $_key => $_value) {
				$array[$key][$_key] = $type === 'read' ? $this->_readValue($_value) : $this->_writeValue($_value);
			}

		}

		return $array;
	}

}

?>