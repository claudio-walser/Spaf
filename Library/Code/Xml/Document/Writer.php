<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Document/Writer.php
 * @created Sun Nov 04 09:48:13 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml\Document;


/**
 * \Spaf\Library\Code\Xml\Document\Writer
 *
 * Trait for write an XML/Document to string
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml\Document
 * @namespace Spaf\Library\Code\Xml\Document
 */
trait Writer {

	/**
	 * XMLWriter instance
	 *
	 * @var \XMLWriter
	 */
	private $_writer = null;

	/**
	 * Get current XMLWriter instance
	 *
	 * @return \XMLWriter XMLWriter instance of this document
	 */
	public function getWriter() {
		return $this->_writer;
	}

	/**
	 * Write document objct to a string
	 *
	 * @return string The Document as string
	 */
	public function toString() {
		// initialize XMLWriter
		$this->_writer = new \XMLWriter();
		$this->_writer->openMemory();

		// write doc tag
		$this->_writer->startDocument($this->getVersion(), $this->getEncoding());

		// write root node
		$this->getRootNode()->toString();

		// close document
		$this->_writer->endDocument();

		// @todo Cache result and return flush(false) here. Then implement a function to really flush the cached XML on any relevant node or doc operation
		return $this->_writer->flush();

	}

	/**
	 * Magic to string to be able to just echo an object
	 *
	 * @return string The Document as string
	 */
	public function __toString() {
		return $this->toString();
	}

}

?>