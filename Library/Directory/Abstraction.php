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
 * The abstract directory/file class.
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
	 * Splits the name and path of a given folder-path.
	 *
	 * @param string Folderpath
	 * @return array Array with name and path seperated
	 */
	public static function getNameAndPath($namePath) {
		$namePath = self::formPath($namePath, false);
		$parts = explode('/', $namePath);

		$name = array_pop($parts);
		$path = self::formPath(implode('/', $parts));

		return array('path' => $path, 'name' => $name);
	}
	
	/**
	 * Every child class has to have a delete method.
	 *
	 * @return boolean True if delete was successful
	 */
	abstract public function delete();
}

?>