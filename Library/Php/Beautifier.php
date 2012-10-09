<?php

/**
 * $Id$
 *
 * Spaf/Library/Php/Beautifier.php
 * @created Mon Oct 08 23:28:54 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Php;


/**
 * \Spaf\Library\Php\Beautifier
 *
 * The Directory class represents a directory object and
 * gives you some functionanlity like
 * read content recursvie, create subfolders
 * recursive and some other folder actions.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Php
 * @namespace Spaf\Library\Php
 */
class Beautifier {

	/**
	 * Array with \Spaf\Library\Directory\File objects
	 *
	 * @var array Array with File objects
	 */
	private $_files = array();

	/**
	 * Set files to handle with the beautifier
	 *
	 * @param mixed Array with \Spaf\Library\Directory\File objects or a single object to handle
	 * @return boolean True
	 */
	public function setFiles($files) {
		// if its a single object
		if (!is_array($files)) {
			// pass it to an array
			$files = array($files);
		}

		// store the array
		$this->_files = $files;

		return true;
	}

	/**
	 * Run the beautify functions on all files
	 *
	 * @return boolean True
	 */
	public function beautify() {
		foreach($this->_files as $file) {
			$this->_dispatch($file);
		}

		return true;
	}

	/**
	 * Run the beautify functions on one file
	 *
	 * @param mixed Can be everything yet, but only \Spaf\Library\Directory\File are processed
	 * @return boolean True
	 */
	private function _dispatch($file) {
		if (!$file instanceof \Spaf\Library\Directory\File) {
			return false;
		}

		$this->_handleTabs($file);
		$this->_removeTrailingSpaces($file);

		return true;
	}

	/**
	 * Handle different tab options
	 *
	 * @param \Spaf\Library\Directory\File File to process
	 * @return boolean True
	 */
	private function _handleTabs(\Spaf\Library\Directory\File $file) {
		$lines = $file->getLines();

		foreach ($lines as $key => $line) {
			$lines[$key] = str_replace('	', "\t", $line);
		}

		$file->setLines($lines);

		return true;
	}

	/**
	 * Remove trailing spaces on each line
	 *
	 * @param \Spaf\Library\Directory\File File to process
	 * @return boolean True
	 */
	private function _removeTrailingSpaces(\Spaf\Library\Directory\File $file) {
		$lines = $file->getLines();

		foreach ($lines as $key => $line) {
			$lines[$key] = rtrim($line);
		}

		$file->setLines($lines);

		return true;
	}

}

?>