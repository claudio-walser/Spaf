<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Reader.php
 * @created Wed Oct 10 21:11:04 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml;


/**
 * \Spaf\Library\Code\Xml\Reader
 *
 * Easy interface for reading xml
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Reader {

	/**
	 * XML Writer object, see www.php.net/xmlreader
	 * 
	 * @var \XMLReader
	 */
	private $_reader = null;
	
	/**
	 * XML string to convert into Document object
	 * 
	 * @var string
	 */
	private $_xmlString = '';
	
	/**
	 * XML Document object if already parsed.
	 * 
	 * @var \Spaf\Library\Code\Xml\Document
	 */
	private $_document = null;
	
	/**
	 * Instantiates a \XMLReader object
	 * to read from.
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->_reader = new \XMLReader();
	}
	
	/**
	 * Set XML String to create the document
	 * object from.
	 * 
	 * @param string The XML string you want to parse
	 * @return boolean True
	 */
	public function setXmlString($string) {
		$this->_xmlString = (string) $string;
		
		return true;
	}
	
	/**
	 * Get the \Spaf\Library\Code\Xml\Document
	 * within its nodes, based on your input
	 * XML String.
	 * 
	 * @return \Spaf\Library\Code\Xml\Document The Document object, based on your xml input
	 */
	public function getDocument() {
		if ($this->_document === null) {
			$this->_document = 'parse it';
		}
		return $this->_document;
	}

}

?>