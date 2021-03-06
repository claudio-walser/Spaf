<?php

/**
 * $Id$
 *
 * Spaf/Library/Directory/Directory.php
 * @created Tue Jun 08 19:24:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Directory;

/**
 * \Spaf\Library\Directory\Directory
 *
 * The Directory class represents a directory object and
 * gives you some functionanlity like
 * read content recursvie, create subfolders
 * recursive and some other folder actions.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Directory
 * @namespace Spaf\Library\Directory
 */
class Directory extends AbstractDirectory {

	/**
	 * The directory name without paths.
	 *
	 * @var string
	 */
	private $_name = '';

	/**
	 * The directory path without aame.
	 *
	 * @var string
	 */
	private $_path = '';

	/**
	 * Manager object
	 *
	 * @var \Spaf\Library\Directory\Manager
	 */
	private $_manager = null;

	/**
	 * Splits the path in foldername and folderpath.
	 *
	 * @param string Path to the directory
	 * @return boolean
	 */
	public function __construct($path) {
		$this->_manager = new Manager();

		$path = self::formPath($path, false);

		if (!is_dir($path)) {
			throw new Exception($path . ' is no valid directory');
		}

		$parts = explode('/', $path);

		$this->_name = array_pop($parts);
		$this->_path = implode('/', $parts) . '/';

		if ($this->_path === '/') {
			$this->_path = '';
		}
	}

	/**
	 * Set a different class to take for directories
	 *
	 * @param string Classname to take for directories
	 * @return boolean
	 */
	public function setDirectoryClass($className) {
		$this->_manager->setDirectoryClass($className);

		return true;
	}

	/**
	 * Set a different class to take for files
	 *
	 * @param string Classname to take for files
	 * @return boolean
	 */
	public function setFileClass($className) {
		$this->_manager->setFileClass($className);

		return true;
	}

	/**
	 * Returns the foldername without path
	 *
	 * @return string
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * Returns the folderpath without name
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->_path;
	}

	/**
	 * Reads the children and returns \Spaf\Library\Directory\Directory
	 * and \Spaf\Library\Directory\File objects.
	 *
	 * @param string Pattern to search for, for more details see www.php.net/glob
	 * @param string Type to read, possible values are * || file || directory, default is * for reading both
	 * @param boolean Read the child elements recursive
	 * @param array Array with folder-names to ignore, only usefull if recursive === true
	 * @return boolean
	 */
	public function getChildren($pattern = '*', $type = null, $recursive = false, array $ignoreDirectories = array()) {
		$onlyDir = false;
		if ($type === 'dir' || $type === 'directory') {
			$onlyDir = true;
		}
		$childs = $this->_manager->readContent($this->_path . $this->_name, $pattern, $onlyDir);

		if ($recursive !== true) {
			return $childs;
		}

		$newChilds = $childs;

		if ($type === 'file') {
			$newChilds = $this->_manager->readContent($this->_path . $this->_name, '*', true);
		}

		foreach ($newChilds as $child) {
			if ($child instanceof Directory && !in_array($child->getName(), $ignoreDirectories)) {
				$childs = array_merge($childs, $child->getChildren($pattern, $type, $recursive, $ignoreDirectories, true));
			}
		}

		return $childs;
	}

	/**
	 * Delete this folder and its content
	 * recursive.
	 *
	 * @return boolean True if deletion was successful
	 */
	public function delete() {
		$children = $this->getChildren();
		foreach ($children as $child) {
			$child->delete();
		}

		return $this->_manager->deleteDirectory($this->_path . $this->_name);
	}

}

?>