<?php

/**
 * $Id$
 *
 * Spaf/Library/Directory/Abstraction.php
 * @created Tue Jun 08 05:21:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Directory;

/**
 * \Spaf\Library\Directory\Abstraction
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
abstract class Abstraction {

	/**
	 * Defines if a path has to be wellformed or not.
	 *
	 * @var boolean
	 */
	protected static $_isWellFormed = false;

	/**
	 * Defines if a path has to be lowercase or not.
	 *
	 * @var boolean
	 */
	protected static $_isLowerCase = false;

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
		$path = self::formPath($path);
		$GLOB = $onlyDir === true ? GLOB_ONLYDIR : GLOB_BRACE;
		return self::_createObjects(glob($path . $pattern, $GLOB));
	}

	/**
	 * Returns a well formed path string with an trailing slash(/).
     *
	 * @param string Directory path to beautify
	 * @param boolean Add a trailing slash or remove
	 * @return string Wellformed path
     */
	public static function formPath($path, $trailingSlash = true) {
		$path = trim($path);
		if (!empty($path)) {
			if (substr($path, -1) !== '/' && $trailingSlash === true) {
				$path .= '/';
			}
			if (substr($path, -1) === '/' && $trailingSlash === false) {
				$path = substr($path, 0, -1);
			}

			if (self::$_isWellFormed === true) {
				$searches[] = ' ';		$replaces[] = '_';
				$searches[] = '*';		$replaces[] = '_';
				$searches[] = '?';		$replaces[] = '_';
				$searches[] = 'ä';		$replaces[] = 'ae';
				$searches[] = 'ö';		$replaces[] = 'oe';
				$searches[] = 'ü';		$replaces[] = 'ue';
				$searches[] = 'Ä';		$replaces[] = 'Ae';
				$searches[] = 'Ö';		$replaces[] = 'Oe';
				$searches[] = 'ä';		$replaces[] = 'ae';
				$searches[] = 'ö';		$replaces[] = 'oe';
				$searches[] = 'ü';		$replaces[] = 'ue';
				$searches[] = 'Ä';		$replaces[] = 'Ae';
				$searches[] = 'Ö';		$replaces[] = 'Oe';
				$searches[] = 'Ü';		$replaces[] = 'Ue';

				$path = str_replace($searches, $replaces, $path);
			}

			if (self::$_isLowerCase === true) {
				$path = strtolower($path);
			}

		}
		return $path;
	}

	/**
	 * Create directories recursivly
	 */
	 public static function createDirectory($directory, $mode = 0777) {
	 	if (is_dir($directory)) {
	 		return true;
	 	}
		
		return mkdir($directory, $mode, true);
		
		/*$currentDir = '';
		$parts = explode('/', $directory);
		
		foreach ($parts as $part) {
				
			$currentDir .= !empty($currentDir) ? '/' : '';
			$currentDir .= $part;
			if (is_dir($currentDir)) {
				continue;
			}
			mkdir($currentDir);
		}
		
		return true;*/
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
			if (is_dir($value)) {
				$array[$key] = new Directory($value);
			} else if (is_file($value)) {
				$array[$key] = new File($value);
			}
		}
		return $array;
	}

}

?>