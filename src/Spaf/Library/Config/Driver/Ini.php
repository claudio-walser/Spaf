<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Ini.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Ini
 *
 * Concrete driver class to handle ini configs.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Ini extends AbstractDriver {

	/**
	 * Read the current given ini file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Two dimensional config Array
	 */
	protected function _read(\Spaf\Library\Directory\File $file) {
		/* dont like it cause true is rad as 1 and stuff like that, and null is an empty string, no matter what you try to do...
		$array = parse_ini_file($this->_sourceFile->getPath() . $this->_sourceFile->getName(), INI_SCANNER_RAW);
		*/
		$array = $this->_parse($file);

		// fix special values
		$array = $this->_handleTypes($array, 'read');

		return $array;
	}

	/**
	 * _write for initializing configuration files.
	 *
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	protected function _write($array, \Spaf\Library\Directory\File $file) {
		$fileContent = '';
		foreach ($array as $sectionName => $sectionArray) {
			if (is_array($sectionArray)) {
				$fileContent .= '[' . $sectionName . ']' . "\n";
				foreach ($sectionArray as $key => $value) {
					// @TODO take care of special values in ini files, not just everything is valid
					// and since i am unescaping in read, i should escape in write maybe :-p
					//$value = $this->_writeValue($value);
					$value = $this->_escapeDoubleQuotes($value);
					$fileContent .= $key . ' = ' . $value . "\n";
				}
			}
			$fileContent .= "\n";
		}
		$fileContent = rtrim($fileContent);

		//echo "hier kommt die maus \n";

		//echo $fileContent;
		//die();


		$file->setContent($fileContent);
		return $file->write();
	}

	public function _escapeDoubleQuotes($value) {
		// only care about double quotes
		if (strpos($value, '"')) {
			$value = '"' . str_replace('"', '\"', $value) . '"';
		}

		return $value;
	}

	/**
	 * Parse the ini file
	 * [values] are section names
	 * key = value are its key value pairs.
	 * Comments are ignored yet and not written at all if you call
	 * $this->save(), take care of this, its a todo for the future if its worth to implement
	 *
	 * @return array Parsed array with two levels, as you get it from www.php.net/parse_ini_file
	 */
	protected function _parse(\Spaf\Library\Directory\File $file) {
		$lines = $file->getLines();

		// initialize values to work with in the loop
		$array = array();
		$currentSection = null;
		foreach ($lines as $line) {
			// create current section array if first section found
			if ($currentSection !== null && !isset($array[$currentSection])) {
				$array[$currentSection] = array();
			}

			// trim spaces
			$line = trim($line);

			// skip comments and empty lines (comments will follow)
			if (empty($line) || $line{0} === ';') {
				continue;
			}

			// opens a new section
			if (substr($line, 0, 1) === '[' && substr($line, -1) === ']') {
				$currentSection = substr($line, 1 , -1);
			}

			// skip any value before a section is found, maybe i will create kind of a GLOBAL namespace for such values in all formats
			if (!isset($array[$currentSection])) {
				continue;
			}

			// read values
			if (strpos($line, '=')) {
				$parts = explode('=', $line);
				$key = trim(array_shift($parts));
				$value =  trim(implode('=', $parts));
				//fill value in current section
				$array[$currentSection][$key] = $this->_parseValue($value);
			}

		}

		return $array;
	}

	/**
	 * Parse a single value could be a bit tricky
	 * cause of some escaped values.
	 *
	 * @param string Raw value
	 * @return string Parsed value
	 */
	protected function _parseValue($value) {
		if (substr($value, 0, 1) === '"' && substr($value, -1) === '"' || substr($value, 0, 1) === "'" && substr($value, -1) === "'") {
			$doubleQuotes = false;
			if (substr($value, 0, 1) === '"') {
				$doubleQuotes = true;
			}
			$value = substr($value, 1 , -1);

			if ($doubleQuotes === true) {
				$value = str_replace('\"', '"', $value);
			} else {
				$value = str_replace("\'", "'", $value);
			}

		}
		return $value;
	}

}

?>