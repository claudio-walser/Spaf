<?php

namespace Spaf\Library\Php;


class Beautifier {
	
	/**
	 * Array with \Spaf\Library\Directory\File objects
	 */
	private $_files = array();
	
	/**
	 * Set files to handle with the beautifier
	 * 
	 * @param mixed Array with \Spaf\Library\Directory\File objects or a single object to handle
	 */
	public function setFiles($files) {
		// if its a single object
		if (!is_array($files)) {
			// pass it to an array
			$tmp = $files;
			$files = array(
				$tmp
			);
		}
		
		// store the array
		$this->_files = $files;
	}
	
	
	public function beautify() {
		foreach($this->_files as $file) {
			$this->_dispatch($file);
		}
	}
	
	private function _dispatch($file) {
		if (!$file instanceof \Spaf\Library\Directory\File) {
			return false;
		}
		
		$this->_handleTabs($file);
		$this->_removeTrailingSpaces($file);
		
		return true;
	}
	
	/**
	 * Changes 4 spaces into a tab
	 */
	private function _handleTabs(\Spaf\Library\Directory\File $file) {
		$lines = $file->getLines();
		
		foreach ($lines as $key => $line) {
			$lines[$key] = str_replace('    ', "\t", $line);
		}
		
		$file->setLines($lines);
		
		return true;
	}
	
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