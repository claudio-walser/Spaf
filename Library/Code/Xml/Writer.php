<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Reader.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml;


/**
 * \Spaf\Library\Code\Xml\Reader
 *
 * Easy interface for reading xml
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Writer {

	/**
	 * File instance to do I/O access
	 */
	private $_file = null;

	/**
	 * Set a File object to work with
	 *
	 * @param \Spaf\Library\Directory\File
	 * @return boolean True
	 */
	public function setFile(\Spaf\Library\Directory\File $file) {
		$this->_file = $file;

		return true;
	}

	/**
	 * Write the xml to a file.
	 * If you pass one File, its stored over setFile() internally
	 * and it will be taken again the next time you call write.
	 * You dont have to passed it twice.
	 *
	 * @param \Spaf\Library\Directory\File File to write into, default to null which meens it takes the one from setFile
	 */
	public function write(\Spaf\Library\Directory\File $file = null) {
		if ($file !== null) {
			$this->setFile($file);
		}

		if ($this->_file === null) {
			throw new Exception('Not set any file to save. Pass one per setFile() or directly to write()');
		}

		// store content
		$file->setContent($this->toString());

		return $file->write();
	}

}

?>