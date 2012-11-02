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
class Ini extends Abstraction {

	/**
	 * Read the current given ini file.
	 *
	 * @throws \Spaf\Library\Config\Driver\Exception Throws an exception if no source file is set yet
	 * @access public
	 * @return array Nested array of the whole config
	 */
	public function read() {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}

		$array['data'] = parse_ini_file($this->_sourceFile->getPath() . $this->_sourceFile->getName(), 1);

		if (!is_array($array) || empty($array)) {
			$array['data'] = array();
		}

		return $array;
	}

	/**
	 * Write the config back to the ini file currently set.
	 *
	 * @param array Nested array with complete config to write
	 * @param string Where to save the file, default to null to take the current one
	 * @return bool True if writing the file was successfull
	 */
	public function save(Array $assoc_array, $filename = null) {
		parent::save($assoc_array, $filename);
		$assoc_array = $assoc_array['data'];
		$file_content = '';
		foreach ($assoc_array as $section => $section_array) {
			if (is_array($section_array)) {
				$file_content .= '[' . $section . ']' . "\n";
				foreach ($section_array as $key => $value) {
					if ($value === false) {
						$value = 'false';
					} else if ($value === true){
						$value = 'true';
					} else if ($value === null){
						$value = 'null';
					}
					$file_content .= $key . ' = ' . $value . "\n";
				}
			}
			$file_content .= "\n";
		}

		$file_content = rtrim($file_content);

		$this->_sourceFile->setContent($file_content);
		return $this->_sourceFile->write($filename);
	}

}

?>