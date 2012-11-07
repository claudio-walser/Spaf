<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Abstraction.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Abstraction
 *
 * This is the abstract basic
 * driver class. Any concrete config driver
 * has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
abstract class Abstraction {

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
	 * Set the source file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean True
	 */
	public function setSourceFile(\Spaf\Library\Directory\File $file) {
		$this->_sourceFile = $file;

		return true;
	}

	/**
	 * Read has to be implemented in any driver.
	 *
	 * @return array Config Array
	 */
	abstract public function read();

	/**
	 * Read has to be implemented in any driver.
	 *
	 * @param array Config Array
	 * @param string Filename to save the file, null to save to the current file object
	 * @return boolean True if saving the file was successful
	 */
	public function save(array $array, $filename = null) {
		if ($this->_sourceFile === null && $filename === null) {
			throw new Exception('Set a source file or give a filename to save the data.');
		}

		if ($this->_sourceFile === null) {
			$dirManager = new \Spaf\Library\Directory\Manager();
			if (!$dirManager->fileExists($filename)) {
				$dirManager->createFile($filename);
			}

			$this->_sourceFile = new \Spaf\Library\Directory\File($filename);
		}

		return true;
	}
	
	protected function _readValue($value) {
		foreach ($this->_valueMap as $key => $val) {
			if ($value === $key || $value === strtoupper($key)) {
				return $val;
			}
		}
			
		return $value;
	}
	
	protected function _writeValue($value) {
		// since it seems php array functions has problems with such values, lets do by our own
		foreach ($this->_valueMap as $key => $val) {
			if ($val === $value || $val === strtolower($value)) {
				// not quite sure why, $key its returning int(1) here???, this small hack works as expected
				// stuff like that did not happen in a strong typed language :-P
				if ($value === null) {
					return 'null';
					echo 'wtf';
					var_dump($key);
				}
				return $key;
			}
		}
		
		return $value;
	}

}

?>