<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Writer.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml;


/**
 * \Spaf\Library\Code\Xml\Writer
 *
 * Easy interface for writing xml
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Writer {

	/**
	 * XML Writer object, see www.php.net/xmlwriter
	 *
	 * @var \XMLWriter
	 */
	private $_writer = null;

	/**
	 * XML Document object to write
	 *
	 * @var \Spaf\Library\Code\Xml\Document
	 */
	private $_document = null;

	/**
	 * Instantiates a \XMLWriter object
	 * to work with.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->_writer = new \XMLWriter();
		$this->_writer->openMemory();
	}

	/**
	 * Set an XML Document object to write.
	 *
	 * @param \Spaf\Library\Code\Xml\Document Document object to write
	 * @return boolean True
	 */
	public function setDocument(\Spaf\Library\Code\Xml\Document $document) {
		$this->_document = $document;

		return true;
	}

	/**
	 * Parse the Document object into
	 * a string and return it.
	 *
	 * @return string XML String based on Document object
	 */
	public function toString() {
		if ($this->_document === null) {
			throw new Exception('Set a document before you try to write something.');
		}

		$this->_document->toString($this->_writer);

		return $this->_writer->flush(false);
	}

	/**
	 * __toString wrapper for calling echo $xmlWriter;
	 *
	 * @return string XML String based on Document object
	 */
	public function __toString() {
		return $this->toString();
	}

}

?>