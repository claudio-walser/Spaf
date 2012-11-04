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

	private $_writer = null;

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

	public function getVersion() {
		return $this->_version;
	}

	public function getEncoding() {
		return $this->_encoding;
	}

	public function getRootNode() {
		return $this->_rootNode;
	}

	/**
	 * Set root node
	 *
	 * @param \Spaf\Library\Code\Xml\Node
	 * @return boolean True
	 */
	public function setRootNode(\Spaf\Library\Code\Xml\Node $node) {
		$this->_rootNode = $node;
		$this->_rootNode->setDocument($this);
		$this->_rootNode->isRoot(true);

		return true;
	}

	public function getWriter() {
		return $this->_writer;
	}

	public function fromString($xml) {
		$reader = new \XMLReader();
		$reader->xml($xml);

		// build it from tokens
		$lastNode = null;
		$nodesByLevel = array();
		$currentLevel = 0;

		while($reader->read()) {
			// OPEN NODE
			if ($reader->nodeType === \XMLReader::ELEMENT) {
				if ($lastNode !== null) {
					$currentLevel++;
				}

				$node = new Node($reader->name);
				$node->setValue($reader->value);

				$lastNode = $node;
				$nodesByLevel[$currentLevel] = $node;

				if ($currentLevel === 0) {
					$this->setRootNode($node);
				} else {
					$parentNode = $nodesByLevel[$currentLevel - 1];
					$parentNode->addChild($node);
				}

				// fetch attributes
				$attributeCount = $reader->attributeCount;
				if ($attributeCount > 0) {
					// move to the first attribute
					$reader->moveToFirstAttribute();

					$node->addAttribute($reader->name, $reader->value);

					// enumerate all attributes
					while ($reader->moveToNextAttribute()) {
						$node->addAttribute($reader->name, $reader->value);
					}
				}
			}


			// TEXT
			if ($reader->nodeType === \XMLReader::TEXT) {
				if ($lastNode !== null) {
					$lastNode->setValue(trim($reader->value));
				}
			}


			// CLOSE NODE
			if ($reader->nodeType === \XMLReader::END_ELEMENT) {
				if ($lastNode !== null) {
					if ($currentLevel > 0) {
						$currentLevel--;
					}
				}
			}
		}

		return true;
	}

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

	public function __toString() {
		return $this->toString();
	}
}

?>