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
 * The directory manager class.
 * This abstract class handles some base stuff,
 * like creating Directory and File objects of a directory path.
 * Also that class is a main tier for handling utf-8 de-/encodes
 * and well formatted paths.
 *
 * @todo Think about put folder/file actions into traits
 * @author Claudio Walser
 * @package Spaf\Library\Directory
 * @namespace Spaf\Library\Directory
 */
class Manager {

	/**
	 * Classname to instantiate directories
	 *
	 * @var string
	 */
	private $_directoryClass = '\Spaf\Library\Directory\Directory';

	/**
	 * Classname to instantiate files
	 *
	 * @var string
	 */
	private $_fileClass = '\Spaf\Library\Directory\File';

	/**
	 * Set a different class to take for directories
	 *
	 * @param string Classname to take for directories
	 * @return boolean
	 */
	public function setDirectoryClass($className) {
		$this->_directoryClass = $className;

		return true;
	}

	/**
	 * Set a different class to take for files
	 *
	 * @param string Classname to take for files
	 * @return boolean True
	 */
	public function setFileClass($className) {
		$this->_fileClass = $className;

		return true;
	}

	/**
	 * Returns an array with \Spaf\Library\Directory\Directory
	 * and \Spaf\Library\Directory\File objects.
	 *
	 * @param string Path to build objects from
	 * @param regex Search Pattern
	 * @param boolean Read only directories - true || false
	 * @return array Array of \Spaf\Library\Directory\Directory and \Spaf\Library\Directory\File objects
	 */
	 public function readContent($path, $pattern = '*', $onlyDir = false) {
		$path = Abstraction::formPath($path);
		$GLOB = $onlyDir === true ? GLOB_ONLYDIR : GLOB_BRACE;
		return $this->_createObjects(glob($path . $pattern, $GLOB));
	}

	/**
	 * Create directories recursivly
	 *
	 * @param Directory path to create
	 * @param Mode for access. Read http://ch.php.net/chmod for more info
	 * @return boolean True or false if it wasnt possible to create the directory
	 */
	 public function createDirectory($directory, $mode = 01777) {
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
	public function createFile($file) {
		$parts = Abstraction::getNameAndPath($file);

		$file = $parts['name'];
		$directory = $parts['path'];

		if ($this->directoryExists($directory) === false) {
			$this->createDirectory($directory);
		}

		return file_put_contents($directory . $file, '');
	}

	/**
	 * Checks if a directory exists
	 *
	 * @param Directory path to check
	 * @return boolean True or false if the directory does not exist yet
	 */
	public function directoryExists($directory) {
		return is_dir($directory);
	}

	/**
	 * Checks if a file exists
	 *
	 * @param File path to check
	 * @return boolean True or false if the file does not exist yet
	 */
	public function fileExists($file) {
		return is_file($file);
	}

	/**
	 * Checks if a file is readable
	 *
	 * @param File path to check
	 * @return boolean True or false wether if the file is readable
	 */
	public function fileIsReadable($file) {
		if ($this->fileExists($file) === false) {
			return false;
		}

		return is_readable($file);
	}

	/**
	 * Returns file size in byte or false
	 * if the file doesnt exist.
	 *
	 * @param string Path to file
	 * @return mixed File size in byte or false in case of an error
	 */
	public function getFileSize($file) {
		if ($this->fileExists($file) === false) {
			return false;
		}

		return filesize($file);
	}

	/**
	 * Returns file size in byte or false
	 * if the file doesnt exist.
	 *
	 * @param string Path to file
	 * @return mixed File size in byte or false in case of an error
	 */
	public function getFileMd5($file) {
		if ($this->fileExists($file) === false) {
			return false;
		}

		return md5_file($file);
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
	public function deleteFile($file) {
		if ($this->fileExists($file) === false) {
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
	public function deleteDirectory($directory) {
		if ($this->directoryExists($directory) === false) {
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
	protected function _createObjects(array $array) {
		foreach ($array as $key => $value) {
			if ($this->directoryExists($value)) {
				$array[$key] = new $this->_directoryClass($value);
			} else if ($this->fileIsReadable($value)) {
				$array[$key] = new $this->_fileClass($value);
			} else {
				unset($array[$key]);
			}
		}
		return $array;
	}

}

?>