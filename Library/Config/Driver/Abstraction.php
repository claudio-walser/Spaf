<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Abstraction.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Abstraction
 *
 * This is the abstract basic
 * driver class. Any concrete config driver
 * has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
abstract class Abstraction {

	/**
	 * Source file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_sourceFile = null;

	/**
	 * Set the source file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean True
	 */
	public function setSourceFile(\Spaf\Library\Directory\File $file) {
		$this->_sourceFile = $file;

		return true;
	}

	/**
     * Read has to be implemented in any driver.
     *
	 * @return array Config Array
     */
	abstract public function read();

	/**
     * Read has to be implemented in any driver.
     *
	 * @param array Config Array
	 * @return boolean True if saving the file was successful
     */
	abstract public function save(array $array);

}

?>