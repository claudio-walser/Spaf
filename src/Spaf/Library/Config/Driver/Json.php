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
class Json extends AbstractDriver {

	/**
	 * Read the current given json file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Two dimensional config Array
	 */
	protected function _read(\Spaf\Library\Directory\File $file) {
		$content = $file->getContent();
		$object = json_decode($content);


		$array = array();
		// Associative array is always an object in javascript object notation
		if (is_object($object) && !empty($object)) {
			foreach ($object as $key => $value) {
				foreach ($value as $_key => $_value) {
					$array[$key][$_key] = $_value;
				}
			}
		}
		return $array;
	}

	/**
	 * _write for json configuration files.
	 *
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	protected function _write($array, \Spaf\Library\Directory\File $file) {
		$fileContent = json_encode($array);
		$file->setContent($fileContent);
		return $file->write();
	}

}

?>