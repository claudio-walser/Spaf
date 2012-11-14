<?php

/**
 * $Id$
 *
 * Spaf/Library/Log/Manager.php
 * @created Wed Oct 03 11:02:06 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log;

/**
 * \Spaf\Library\Log\Manager
 *
 * The log manager class is simply
 * handling the log driver instances itself
 * and give you a unique interface to get each of them.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log
 * @namespace Spaf\Library\Log
 */
class Manager {

	const INFO = 'info';
	const ERROR = 'error';
	const WARNING = 'warning';
	const CRITICAL = 'critical';

	private $_writers = array();

	public function addWriter(\Spaf\Library\Log\Writer\Abstraction $writer) {
		array_push($this->_writers, $writer);

		return true;
	}

	public function log($type, $message) {
		foreach ($this->_writers as $writer) {
			$writer->log($type, $message);
		}
	}

	public function flush() {
		foreach ($this->_writers as $writer) {
			$writer->flush();
		}
	}

}

?>