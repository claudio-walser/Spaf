<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Json.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Json
 *
 * Concrete driver class to handle json configs.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Json extends Abstraction {

	/**
	 * Read the current given json file.
	 *
	 * @throws \Spaf\Library\Config\Driver\Exception Throws an exception if no source file is set yet
     * @access public
     * @return array Nested array of the whole config
	 */
	public function read() {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}


		$content = $this->_sourceFile->getContent();
		$array['data'] = json_decode($content);
		if (!is_array($array) || empty($array)) {
			$array['data'] = null;
		}
		return $array;
	}


	/**
	 * Write the config back to the json file currently set.
	 *
	 * @param array Nested array with complete config to write
     * @return bool True if writing the file was successfull
	 */
	public function save(Array $assoc_array) {
		$assoc_array = $assoc_array['data'];
		$file_content = json_encode($assoc_array);
		$this->_sourceFile->setContent($file_content);
		return $this->_sourceFile->write();
	}


}
?>