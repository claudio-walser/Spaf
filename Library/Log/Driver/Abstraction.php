<?php

/**
 * $Id$
 *
 * Spaf/Library/Log/Driver/Abstraction.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log\Driver;

/**
 * \Spaf\Library\Log\Driver\Abstraction
 *
 * This is the abstract basic
 * driver class. Any concrete log driver
 * has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log\Driver
 * @namespace Spaf\Library\Log\Driver
 */
abstract class Abstraction {

	/**
	 * Notify method of each log driver
	 *
	 * @param string String to handle with the log driver
	 * @return boolean True if notification was successful
	 */
	abstract public function notify($log);

}

?>