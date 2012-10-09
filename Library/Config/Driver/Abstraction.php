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
     * Read has to be implemented in any driver.
     *
	 * @return array Comment Array
     */
	abstract function read();

	/**
     * Read has to be implemented in any driver.
     *
	 * @param array Comment Array
	 * @return boolean True if saving the file was successful
     */
	abstract function save(array $assoc_array);
}

?>