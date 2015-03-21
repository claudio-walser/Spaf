<?php

/**
 * $Id$
 *
 * Spaf/Library/Primitive/String.php
 * @created Sat Jun 21 00:46:03 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */

namespace Spaf\Library\Primitive;

/**
 * \Spaf\Library\Primitive\String
 *
 * Simple string manipulation.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Primitive
 * @namespace Spaf\Library\Primitive
 * @abstract
 */
class String {

	/**
	 * Content as native string.
	 *
	 * @var string
	 */
	private $_content = '';

	/**
	 * Whether its a compressed string or not
	 *
	 * @var bool
	 */
	private $_compressed = false;

	/**
	 * Construct a String Object by pass a string.
	 * Note: anything you pass on this is casted to a string.
	 *
	 * @param string String to set as content
	 * @param bool Whether its a compressed string or not 
	 */
	public function __construct($string = '', $compressed = false) {
		$this->set($string, $compressed);
	}
	
	/**
	 * Set current content
	 *
	 * @param string
	 * @param bool Whether its a compressed string or not 
	 * @return boolean
	 */
	public function set($string, $compressed = false) {
		$this->_compressed = (bool) $compressed;
		return $this->_content = (string) $string;
	}

	/**
	 * Get current content
	 *
	 * @return string Content of the current object
	 */
	public function get() {
		return $this->_content;
	}

	/**
	 * Get a random string
	 * 
	 * This method sets a random string and overwrite the original content value.
	 * Its length depends on your passed parameter. By default its 6 signs.
     *
	 * @param int Length of the string
	 * @return string Returns true if creation went ok
     */
	public function createRandom($length = 6) {
		$string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$return_string = ''; 
		mt_srand((double)microtime()*1000000); 
		while (strlen($return_string) <= 0) {
			
			for ($i=1; $i <= $length; $i++) { 
				$return_string .= substr($string, mt_rand(0,strlen($string)-1), 1);
			}
			
			// Ab Sechs Zeichen prüfen ob von allem eins drin ist.
			if ($length > 5) {
				if (!preg_match('/[0-9]/', $return_string) || !preg_match('/[a-z]/', $return_string)|| !preg_match('/[A-Z]/', $return_string)) {
					$return_string = "";
				}
			}
		}

		return $this->set($return_string, false);
	}

	/**
	 * Create a gzip compressed string
	 * 
	 * @param int Level of compression. Can be given as 0 for no compression up to 9 for maximum compression. -1 for default zlib compression level.
	 * @return bool Returns true if compression went ok
     */
	public function gzencode($level = -1) {
		if ($this->_compressed === true) {
			return false;
		}
		$this->_compressed = true;

		return $this->_content = gzencode($this->_content, $level);
	}

	/**
	 * Decodes a gzip compressed string
	 * 
	 * @return bool Returns true if decoding went ok
     */
	public function gzdecode() {
		if ($this->_compressed === false) {
			return false;
		}
		$this->_compressed = false;
		
		return $this->_content = gzdecode($this->_content);
	}

	/**
	 * Simply return the content
	 *
	 * @return string Content of the current object
	 */
	public function __toString() {
		return $this->get();
	}

}