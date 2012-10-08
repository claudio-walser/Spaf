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
class Directory extends Abstraction {

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
	 * Splits the path in foldername and folderpath.
	 *
	 * @param string Path to the directory
	 * @return boolean
	 */
	public function __construct($path) {
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
	 * @param boolean $recursive Read the child elements recursive
	 * @return boolean
	 */
	public function getChildren($pattern = '*', $type = null, $recursive = false, array $ignoreDirectories = array()) {
		$onlyDir = false;
		if ($type === 'dir' || $type === 'directory') {
			$onlyDir = true;
		}
		$childs = Abstraction::readContent($this->_path . $this->_name, $pattern, $onlyDir);

		if ($recursive !== true) {
			return $childs;
		}
		
		$newChilds = $childs;
		
		if ($type === 'file') {
			$newChilds = Abstraction::readContent($this->_path . $this->_name, '*', true);
		}
		
		foreach ($newChilds as $child) {
			if ($child instanceof Directory && !in_array($child->getName(), $ignoreDirectories)) {
				$childs = array_merge($childs, $child->getChildren($pattern, $type, $recursive, $ignoreDirectories));
			}
		}

		return $childs;
	}

}

?>