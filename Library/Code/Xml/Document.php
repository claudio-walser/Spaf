<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Document.php
 * @created Sat Nov 03 02:50:13 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml;


/**
 * \Spaf\Library\Code\Xml\Document
 *
 * Represents a XML document
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Document {

	/**
	 * XML Version
	 * 
	 * @var string
	 */
	private $_version = '1.0';
	
	/**
	 * Encoding
	 * 
	 * @var string
	 */
	private $_encoding = 'UTF-8';
	
	/**
	 * Root node
	 * 
	 * @var \Spaf\Library\Code\Xml\Node
	 */
	private $_rootNode = null;
	
	/**
	 * Instantiates a \XMLWriter object
	 * to work with.
	 * 
	 * @param string XML Version, default to 1.0
	 * @param string Encoding, default to UTF-8
	 * @return void
	 */
	public function __construct($version = '1.0', $encoding = 'UTF-8') {
		$this->_version = (string) $version;
		$this->_encoding = (string) $encoding;
	}
	
	/**
	 * Set root node
	 * 
	 * @param \Spaf\Library\Code\Xml\Node
	 * @return boolean True
	 */
	public function setRootNode(\Spaf\Library\Code\Xml\Node $noe) {
		$this->_rootNode = $node;
		
		return true;
	}
}

?>