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
class Php extends AbstractDriver {

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

}

?>