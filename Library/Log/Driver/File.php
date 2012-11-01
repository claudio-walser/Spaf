<?php

 /**
 * $Id$
 *
 * Spaf/Library/Log/Driver/Json.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log\Driver;

/**
 * \Spaf\Library\Log\Driver\Json
 *
 * Concrete driver class to write logs into a textfile.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Log\Driver
 * @namespace Spaf\Library\Log\Driver
 */
class File extends Abstraction {

	/**
	 * Source file object
	 *
	 * @var \Spaf\Library\Directory\File
	 */
	protected $_sourceFile = null;

	/**
	 * Set the source file to write logs into.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean True
	 */
	public function setSourceFile(\Spaf\Library\Directory\File $file) {
		$this->_sourceFile = $file;

		return true;
	}

	/**
	 * Notify method of each log driver
	 *
	 * @todo Most simple solution now, improve that
	 * @param string String to write into the file
	 * @return boolean True if save the file was successfull
	 */
	public function notify($log) {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}


		$content = $this->_sourceFile->getContent();
		$content .= "\n" . $log;

		$this->_sourceFile->setContent($content);
	}

}

?>