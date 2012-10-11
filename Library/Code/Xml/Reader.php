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
class Reader {
	
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
	 * Return well formed xml string
	 * 
	 * @return string Well fromed XML as string
	 */
	public function toString() {
		return 'xml';
	}
	
}

?>