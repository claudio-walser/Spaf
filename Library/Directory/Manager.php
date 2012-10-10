<?php

/**
 * $Id$
 *
 * Spaf/Library/Directory/Manager.php
 * @created Tue Jun 08 05:21:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Directory;

/**
 * \Spaf\Library\Directory\Manager
 *
 * The base directory class.
 * This abstract class handles some base stuff,
 * like creating Directory and File objects of a directory path.
 * Also that class is a main tier for handling utf-8 de-/encodes
 * and well formatted paths.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Directory
 * @namespace Spaf\Library\Directory
 */
abstract class Manager {

	/**
	 * Returns an array with \Spaf\Library\Directory\Directory
	 * and \Spaf\Library\Directory\File objects.
	 *
	 * @param string Path to build objects from
	 * @param regex Search Pattern
	 * @param boolean Read only directories - true || false
	 * @return array Array of \Spaf\Library\Directory\Directory and \Spaf\Library\Directory\File objects
	 */
	 public static function readContent($path, $pattern = '*', $onlyDir = false) {
		$path = Abstraction::formPath($path);
		$GLOB = $onlyDir === true ? GLOB_ONLYDIR : GLOB_BRACE;
		return self::_createObjects(glob($path . $pattern, $GLOB));
	}

	/**
	 * Create directories recursivly
	 *
	 * @param Directory path to create
	 * @param Mode for access. Read http://ch.php.net/chmod for more info
	 * @return boolean True or false if it wasnt possible to create the directory
	 */
	 public static function createDirectory($directory, $mode = 01777) {
	 	if (is_dir($directory)) {
	 		return true;
	 	}

		return mkdir($directory, $mode, true);
	}

	/**
	 * Creates or creates a file.
	 *
	 * @param string Filename
	 * @return boolean True or false if create failed
	 */
	public static function createFile($file) {
		$parts = Abstraction::getNameAndPath($file);

		$file = $parts['name'];
		$directory = $parts['path'];

		if (self::directoryExists($directory) === false) {
			self::createDirectory($directory);
		}

		return file_put_contents($directory . $file, '');
	}

	/**
	 * Checks if a directory exists
	 *
	 * @param Directory path to check
	 * @return boolean True or false if the directory does not exist yet
	 */
	public static function directoryExists($directory) {
		return is_dir($directory);
	}

	/**
	 * Checks if a file exists
	 *
	 * @param File path to check
	 * @return boolean True or false if the file does not exist yet
	 */
	public static function fileExists($file) {
		return is_file($file);
	}

	/**
	 * Checks if a file is readable
	 *
	 * @param File path to check
	 * @return boolean True or false wether if the file is readable
	 */
	public static function fileIsReadable($file) {
		if (self::fileExists($file) === false) {
			return false;
		}

		return is_readable($file);
	}

	/**
	 * Tries to delete a file by path.
	 * If the file does not exists, it returns true.
	 * This means, if you get true back from
	 * this method, you can be sure the file isnt
	 * there anymore.
	 *
	 * @param string Filename to delete
	 * @return boolean True if file removed otherwise false
	 */
	public static function deleteFile($file) {
		if (self::fileExists($file) === false) {
			return true;
		}

		return unlink($file);
	}

	/**
	 * Tries to delete a folder by path.
	 * This method does not work recursive.
	 * So if your folder isnt empty, it wont work.
	 *
	 * @param string Directoryname to delete
	 * @return boolean True if directory removed otherwise false
	 */
	public static function deleteDirectory($directory) {
		if (self::directoryExists($directory) === false) {
			return true;
		}
		return rmdir($directory);
	}

	/**
	 * Creates \Spaf\Library\Directory\Directory and \Spaf\Library\Directory\File
	 * objects from a given array containing file/folder paths.
	 *
	 * @param array Array with file/folder paths
	 * @return array Array with \Spaf\Library\Directory\File or \Spaf\Library\Directory\Directory objects
	 */
	protected static function _createObjects(array $array) {
		foreach ($array as $key => $value) {
			if (self::directoryExists($value)) {
				$array[$key] = new Directory($value);
			} else if (self::fileIsReadable($value)) {
				$array[$key] = new File($value);
			} else {
				unset($array[$key]);
			}
		}
		return $array;
	}

}

?>