<?php

 /**
 * $Id$
 *
 * Spaf/Library/Log/Writer/File.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Log\Writer;

/**
 * \Spaf\Library\Log\Writer\File
 *
 * Concrete driver class to write logs into a textfile.
 *
 * @todo Improve to provide different file types as XML, PLAIN, HTML or JSON (dont have more ideas yet :p)
 * @author Claudio Walser
 * @package Spaf\Library\Log\Writer
 * @namespace Spaf\Library\Log\Writer
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
	 * Get the current source file
	 *
	 * @return \Spaf\Library\Directory\File Source file
	 */
	public function getSourceFile() {
		return $this->_sourceFile;
	}

	/**
	 * Log method for text file logger
	 *
	 * @param string Error type to handle this message
	 * @param string Message to log
	 * @return boolean True if notification was successful
	 */
	public function log($type, $message) {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}

		// replace tabs with a space, since tab is the delimiter sign
		// between type and message in this simple text format
		// newlines as well since one line means one entry
		$message = preg_replace('/\s+/msi', ' ', $message);

		$content = $this->_sourceFile->getContent();
		// newline if not empty content
		$content = !empty($content) ? $content . "\n" : '';
		// add new log entry
		$content .= $type . "\t" . $message;

		$this->_sourceFile->setContent($content);
		return $this->_sourceFile->write();
	}

	/**
	 * Empty the log file
	 *
	 * @return boolean True if successfully cleared
	 */
	public function clear() {
		$this->_sourceFile->setContent('');
		return $this->_sourceFile->write();
	}

}

?>