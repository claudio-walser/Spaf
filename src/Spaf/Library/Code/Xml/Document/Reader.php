<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Document/Reader.php
 * @created Sat Sun 04 09:51:36 +0200 2012
 *
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml\Document;

/**
 * \Spaf\Library\Code\Xml\Reader
 *
 * Trait for read an XML/Document from a string
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml\Document
 * @namespace Spaf\Library\Code\Xml\Document
 */
trait Reader {

	/**
	 * Create a ocument object with its nodes from a XML String
	 *
	 * @param string XML string to parse
	 * @param boolean True
	 */
	public function fromString($xml) {
		// XMLReader object to work with
		$reader = new \XMLReader();
		$reader->xml($xml);

		// build it from tokens
		$lastNode = null;
		$nodesByLevel = array();
		$currentLevel = 0;

		// loop through nodes
		while($reader->read()) {
			// OPEN NODE
			if ($reader->nodeType === \XMLReader::ELEMENT) {
				if ($lastNode !== null) {
					$currentLevel++;
				}
				// create node with its attributes
				$node = $this->_createNode($reader);

				$lastNode = $node;
				$nodesByLevel[$currentLevel] = $node;

				// if current level is zero, its the root node
				if ($currentLevel === 0) {
					$this->setRootNode($node);
				// else just add the node to its parent
				} else {
					$parentNode = $nodesByLevel[$currentLevel - 1];
					$parentNode->addChild($node);
				}
			}


			// TEXT, put value into the last opened node
			if ($reader->nodeType === \XMLReader::TEXT) {
				if ($lastNode !== null) {
					$lastNode->setValue(trim($reader->value));
				}
			}


			// CLOSE NODE, just decrease the current level of nodes
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

	/**
	 * Creates a node of the current Reader Element
	 *
	 * @param \XMLReader Reader object pointed to the right position already
	 * @return \Spaf\Library\Code\Xml\Node The node with its attributes
	 */
	private function _createNode(\XMLReader $reader) {
		if ($reader->nodeType !== \XMLReader::ELEMENT) {
			throw new Exception('You tried to create a node with something else than a XMLReader::ELEMENT');
		}

		$node = new \Spaf\Library\Code\Xml\Node($reader->name);
		$node->setValue($reader->value);
		$this->_fetchNodeAttributes($reader, $node);

		return $node;
	}

	/**
	 * Fetch attributes of a XMLReader::ELEMENT and put it into the node object
	 *
	 * @param \XMLReader Reader object pointed to the right position already
	 * @param \Spaf\Library\Code\Xml\Node The node to put the found attributes into
	 * @return boolean True
	 */
	private function _fetchNodeAttributes(\XMLReader $reader , \Spaf\Library\Code\Xml\Node $node) {
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

		return true;
	}

}

?>