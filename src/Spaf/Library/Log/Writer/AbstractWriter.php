<?php

/**
 * $Id$
 *
 * Spaf/Library/Log/Writer/AbstractWriter.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log\Writer;

/**
 * \Spaf\Library\Log\Writer\AbstractWriter
 *
 * This is the abstract basic
 * writer class. Any concrete log writer
 * has to extend this
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log\Writer
 * @namespace Spaf\Library\Log\Writer
 */
abstract class AbstractWriter {

	/**
	 * Notify method of each log writer
	 *
	 * @param string Error type to handle this message
	 * @param string Message to log
	 * @return boolean True if notification was successful
	 */
	abstract public function log($type, $message);

	/**
	 * Clear the current store
	 *
	 * @return boolean True if successfully cleared
	 */
	abstract public function clear();

}

?>