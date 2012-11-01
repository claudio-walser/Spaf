<?php

/**
 * $Id$
 *
 * Spaf/Library/Code/Php/Beautifier.php
 * @created Mon Oct 08 23:28:54 CET 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Php;


/**
 * \Spaf\Library\Code\Php\Beautifier
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
	 * Namespace is starting with a \ or not
	 *
	 * @var boolean
	 */
	private $_startingBackslash = false;

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
		$this->_fixStartingBackslash($file);
		//$this->_fixNewLines($file);
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
			// haha, of course its replacing this four spaces as well
			// so it just worked for the first time, hope it doesent change too much now :-P
			$lines[$key] = str_replace('  ' . '  ', "\t", $line);
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

	/**
	 * Sometimes, i tend to add a starting backslash in namespace defintion or tags
	 * it might work but end up in a documentation error.
	 * So here comes the fix.
	 *
	 * @param \Spaf\Library\Directory\File File to process
	 * @return boolean True
	 */
	private function _fixStartingBackslash(\Spaf\Library\Directory\File $file) {
		$lines = $file->getLines();

		foreach ($lines as $key => $line) {
			$line = ltrim($line);

			//namespace \Spaf\Core
			if (strtolower(substr($line, 0, 9)) === 'namespace') {
				if ($this->_startingBackslash === true) {
					$lines[$key] = str_replace('namespace Spaf', 'namespace \\Spaf', $line);
				} else {
					$lines[$key] = str_replace('namespace \\Spaf', 'namespace Spaf', $line);
				}
				$lines[$key] = ltrim($lines[$key]);

			// * @package \Spaf\Core
			} else if (strtolower(substr($line, 0, 10)) === '* @package') {
				if ($this->_startingBackslash === true) {
					$lines[$key] = str_replace('* @package Spaf', ' * @package \\Spaf', $line);
				} else {
					$lines[$key] = str_replace('* @package \\Spaf', ' * @package Spaf', $line);
				}
				$lines[$key] = ' ' . ltrim($lines[$key]);

			// * @namespace \Spaf\Core
			} else if (strtolower(substr($line, 0, 12)) === '* @namespace') {
				if ($this->_startingBackslash === true) {
					$lines[$key] = str_replace('* @namespace Spaf', ' * @namespace \\Spaf', $line);
				} else {
					$lines[$key] = str_replace('* @namespace \\Spaf', ' * @namespace Spaf', $line);
				}
				$lines[$key] = ' ' . ltrim($lines[$key]);

			}
		}

		$file->setLines($lines);

		return true;
	}


	/**
	 * Fixes windows new lines and changes into linux styled ones.
	 *
	 * @param \Spaf\Library\Directory\File File to process
	 * @return boolean True
	 */
	private function _fixNewLines(\Spaf\Library\Directory\File $file) {
		$content = $file->getContent();

		$content = str_replace("\r\n", "\n", $content);
		$file->setContent($content);

		return true;
	}

}

?>