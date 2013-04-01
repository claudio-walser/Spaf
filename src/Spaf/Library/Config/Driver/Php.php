<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Php.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Php
 *
 * Concrete driver class to handle php configs.
 * Any php config file is simply included,
 * and should contain a $config array definition.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Php extends Abstraction {

	protected $_unconvertableRead = true;
	protected $_unconvertableWrite = true;

	/**
	 * Read the current given php file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Two dimensional config Array
	 */
	protected function _read(\Spaf\Library\Directory\File $file) {
		$config =  array();

		require($this->_sourceFile->getPath() . $this->_sourceFile->getName());

		return $config;
	}

	/**
	 * _write for php configuration files.
	 *
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	protected function _write($array, \Spaf\Library\Directory\File $file) {
		$fileContent = '<?php' . "\n\n";
		foreach ($array as $sectionName => $sectionArray) {
			if (is_array($sectionArray)) {
				foreach ($sectionArray as $key => $value) {
					// write different types
					if ($value === true) {
						$fileContent .= '$config[\'' . $sectionName . '\'][\'' . $key . '\'] = true;' . "\n";
					} else if ($value === false) {
						$fileContent .= '$config[\'' . $sectionName . '\'][\'' . $key . '\'] = false;' . "\n";
					} else if ($value === null) {
						$fileContent .= '$config[\'' . $sectionName . '\'][\'' . $key . '\'] = null;' . "\n";
					} else if (is_numeric($value)) {
						$fileContent .= '$config[\'' . $sectionName . '\'][\'' . $key . '\'] = ' . $value . ';' . "\n";
					} else {
						$value = $this->_escapeSingleQuotes($value);
						$fileContent .= '$config[\'' . $sectionName . '\'][\'' . $key . '\'] = \'' . $value . '\';' . "\n";
					}
				}
			}
			$fileContent .= "\n";
		}
		$fileContent .= '?>';

		$file->setContent($fileContent);
		return $file->write();

	}

	private function _escapeSingleQuotes($value) {
		$value = str_replace("'", "\'", $value);
		return $value;
	}

	/*
	private $_toEscape = array(
		'\\'

	);

	private $_allowedToStrip = array();

	/**
	 * Read the current given php file.
	 *
	 * @throws \Spaf\Library\Config\Driver\Exception Throws an exception if no source file is set yet
	 * @access public
	 * @return array Nested array of the whole config
	 * /
	public function read() {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}

		require($this->_sourceFile->getPath() . $this->_sourceFile->getName());

		if (!isset($config)) {
			$config = array();
		}

		$array = array(
			'data' => $config
		);

		return $array;

	}

	/**
	 * Write the config back to the php file currently set.
	 *
	 * @TODO Make it configurable if you want nice array notation or one complete single elment per line (as input against output of the copy file in the tests)
	 * @param array Nested array with complete config to write
	 * @param string Where to save the file, default to null to take the current one
	 * @return bool True if writing the file was successfull
	 * /
	public function save(Array $assoc_array, $filename = null) {
		parent::save($assoc_array, $filename);
		$assoc_array = $assoc_array['data'];
		$file_content = '<?php' . "\n\n";
		foreach ($assoc_array as $section => $section_array) {

			if (is_array($section_array)) {
				foreach ($section_array as $key => $value) {
					foreach ($this->_toEscape as $char_to_escape) {
						$value = str_replace($char_to_escape, $char_to_escape . '\\', $value);
					}
					if ($value === false) {
						$value = 'false';
					} else if ($value === null) {
						$value = 'null';
					}
					if (is_numeric($value) || in_array($value, $this->_allowedToStrip)) {
						$file_content .= '$config[\'' . $section . '\'][\'' . $key . '\'] = ' . $value . ';' . "\n";
					} else {
						$file_content .= '$config[\'' . $section . '\'][\'' . $key . '\'] = \'' . $value . '\';' . "\n";
					}

				}
			}
			$file_content .= "\n";
		}
		$file_content .= '?>';

		$this->_sourceFile->setContent($file_content);
		return $this->_sourceFile->write($filename);
	}
	*/


}

?>