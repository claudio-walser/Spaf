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
 * @todo Provide more writers as Database, Exceptions (maybe), Spaf\Library\Debug (if existent), Spaf\Library\Mail (if existent), Syslog (www.php.net/syslog looks quite intersting for logging)
 * @todo Re-Think types, maybe adapt to PHP Error Types as E_WARNING, E_NOTICE and so on, or maybe adapt to firebug which is a known logging tool in dev world...
 * @author Claudio Walser
 * @package Spaf\Library\Log
 * @namespace Spaf\Library\Log
 */
class Manager {

	/**
	 * Log Type info
	 *
	 * @var string
	 */
	const INFO = 'info';

	/**
	 * Log Type error
	 *
	 * @var string
	 */
	const ERROR = 'error';

	/**
	 * Log Type warning
	 *
	 * @var string
	 */
	const WARNING = 'warning';

	/**
	 * Log Type critical
	 *
	 * @var string
	 */
	const CRITICAL = 'critical';

	/**
	 * Writer instances
	 *
	 * @var array
	 */
	private $_writers = array();

	/**
	 * Add a writer to log for this instance
	 *
	 * @param \Spaf\Library\Log\Writer\AbstractWriter class to log into
	 * @return boolean True
	 */
	public function addWriter(\Spaf\Library\Log\Writer\AbstractWriter $writer) {
		array_push($this->_writers, $writer);

		return true;
	}

	/**
	 * Log a message with a given type to all writers
	 *
	 * @param string Type to log, its allowed anything but you are supposed to prefer the predefined ones
	 * @param string Any single line message, newlines are removed
	 * @return boolean True
	 */
	public function log($type, $message) {
		foreach ($this->_writers as $writer) {
			$writer->log($type, $message);
		}

		return true;
	}

	/**
	 * Clear the logs from all writers
	 *
	 * @return boolean True
	 */
	public function clear() {
		foreach ($this->_writers as $writer) {
			$writer->clear();
		}

		return true;
	}

	/**
	 * Hard implementation of info to have
	 * it well and clear documented.
	 * Would work with __call as well.
	 *
	 * @param string Message to log
	 * @return boolean true
	 */
	public function info($message) {
		return $this->log(self::INFO, $message);
	}

	/**
	 * Hard implementation of error to have
	 * it well and clear documented.
	 * Would work with __call as well.
	 *
	 * @param string Message to log
	 * @return boolean true
	 */
	public function error($message) {
		return $this->log(self::ERROR, $message);
	}

	/**
	 * Hard implementation of warning to have
	 * it well and clear documented.
	 * Would work with __call as well.
	 *
	 * @param string Message to log
	 * @return boolean true
	 */
	public function warning($message) {
		return $this->log(self::WARNING, $message);
	}

	/**
	 * Hard implementation of critical to have
	 * it well and clear documented.
	 * Would work with __call as well.
	 *
	 * @param string Message to log
	 * @return boolean true
	 */
	public function critical($message) {
		return $this->log(self::CRITICAL, $message);
	}

	/**
	 * Magic function for calling any type directly
	 *
	 * @param string Name of the called function taken as LOG TYPE
	 * @param array Given argumenst, takes only first param as message
	 * @return boolean True
	 */
	public function __call($name, $arguments) {
		$message = isset($arguments[0]) ? (string) $arguments[0] : '';
		return $this->log($name, $message);
	}

}

?>