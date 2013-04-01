<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Serialized.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Serialized
 *
 * Concrete driver class to handle php serialized configs.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Serialized extends Abstraction {

	/**
	 * Read the current given serialized file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Two dimensional config Array
	 */
	protected function _read(\Spaf\Library\Directory\File $file) {
		$content = $file->getContent();
		$array = unserialize($content);
		if (!is_array($array) || empty($array)) {
			$array = array();
		}

		return $array;
	}

	/**
	 * _write for serialized configuration files.
	 *
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	protected function _write($array, \Spaf\Library\Directory\File $file) {
		$fileContent = serialize($array);
		$file->setContent($fileContent);
		return $file->write();
	}

}

?>