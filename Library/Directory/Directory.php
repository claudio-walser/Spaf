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
	 * Default classname to instantiate directories
	 * 
	 * @var string
	 */
	protected $_defaultDirectoryClass = '\Spaf\Library\Directory\Directory';

	/**
	 * Default classname to instantiate files
	 * 
	 * @var string
	 */
	protected $_defaultFileClass = '\Spaf\Library\Directory\File';

	/**
	 * Classname to instantiate directories
	 * 
	 * @var string
	 */
	private $_directoryClass = '';

	/**
	 * Classname to instantiate files
	 * 
	 * @var string
	 */
	private $_fileClass = '';

 	
	/**
	 * Splits the path in foldername and folderpath.
	 *
	 * @param string Path to the directory
	 * @return boolean
	 */
	public function __construct($path) {
		$this->_directoryClass = $this->_defaultDirectoryClass;
		$this->_fileClass = $this->_defaultFileClass;
		
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
		$this->_directoryClass = $className;
		
		return true;
	}

	/**
	 * Set a different class to take for files
	 * 
	 * @param string Classname to take for files
	 * @return boolean
	 */
	public function setFileClass($className) {
		$this->_fileClass = $className;
		
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
	public function getChildren($pattern = '*', $type = null, $recursive = false, array $ignoreDirectories = array(), $bool = false) {
		// set classnames if set
		if ($this->_directoryClass !== $this->_defaultDirectoryClass) {
			Manager::setDirectoryClass($this->_directoryClass);
		}
		if ($this->_fileClass !== $this->_defaultFileClass) {
			Manager::setDirectoryClass($this->_fileClass);
		}
		
		if ($bool === true) {
			echo $this->_defaultDirectoryClass . "\n";
			echo $this->_defaultFileClass . "\n";
		}
		
		$onlyDir = false;
		if ($type === 'dir' || $type === 'directory') {
			$onlyDir = true;
		}
		$childs = Manager::readContent($this->_path . $this->_name, $pattern, $onlyDir);
		
		if ($recursive !== true) {
			return $childs;
		}

		$newChilds = $childs;

		if ($type === 'file') {
			$newChilds = Manager::readContent($this->_path . $this->_name, '*', true);
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

		return Manager::deleteDirectory($this->_path . $this->_name);
	}

}

?>