<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Node.php
 * @created Sat Nov 03 02:55:13 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml;

/**
 * \Spaf\Library\Code\Xml\Node
 *
 * Represents a XML node
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Node {

	/**
	 * Contains cdata
	 *
	 * @var boolean
	 */
	private $_cdata = false;

	/**
	 * Node name
	 *
	 * @var string
	 */
	private $_name = 'node';

	/**
	 * Value of this node,
	 * its set to null as soon as
	 * you add a child node.
	 */
	private $_value = null;

	/**
	 * Node Attributes as key/value array
	 *
	 * @var array
	 */
	private $_attributes = array();

	/**
	 * Child nodes as array
	 *
	 * @var array
	 */
	private $_children = array();

	/**
	 * Parent node or null if its the root node
	 *
	 * @var mixed
	 */
	private $_parent = null;

	/**
	 * How many indents should this node have.
	 * Its usually set by calling setParentNode.
	 * It fetches the value from parent and adds plus one.
	 *
	 * @var integer
	 */
	private $_indent = 0;

	/**
	 * Indent string to multiply
	 *
	 * @var string
	 */
	private $_indentString = "\t";

	private $_document = null;
	private $_isRoot = false;

	/**
	 * Store the node name.
	 *
	 * @param string Node name
	 * @return void
	 */
	public function __construct($name = 'node') {
		$this->_name = (string) $name;
	}

	public function setDocument(\Spaf\Library\Code\Xml\Document $document) {
		$this->_document = $document;
		foreach ($this->getChildren() as $childNode) {
			$childNode->setDocument($this->_document);
		}
		return true;
	}

	public function getDocument() {
		return $this->_document;
	}

	public function isRoot($boolean = null) {
		if ($boolean === null) {
			$boolean = $this->_isRoot;
		}

		$this->_isRoot = (bool) $boolean;

		if (count($this->getChildren() !== 0)) {
			$this->_isRoot = false;
		}

		return $this->_isRoot;;
	}

	/**
	 * Return the current indent value.
	 *
	 * @return integer CUrrent indent value
	 */
	public function getIndent() {
		return $this->_indent;
	}

	/**
	 * Set indent for this node.
	 *
	 * @param integer Indent for this node
	 * @return boolean True
	 */
	public function setIndent($indent) {
		$this->_indent = (int) $indent;

		// loop and fix all child indents
		foreach ($this->getChildren() as $childNode) {
			$childNode->setIndent($this->getIndent() + 1);
		}

		return true;
	}

	/**
	 * Set a string for drawing indents.
	 * This is multiplied by current amount of indents.
	 *
	 * @param string Set string to use for indents
	 * @return boolean True
	 */
	public function setIndents($string) {
		$this->_indentString = (string) $string;

		return true;
	}

	/**
	 * Set a value for this node
	 *
	 * @param string Value for this node
	 * @return boolean True
	 */
	public function setValue($value) {
		$this->_value = (string) $value;

		return true;
	}

	/**
	 * Set the parent node,
	 * this is usually set by adding a node
	 * with Node::addChild()
	 *
	 * @param \Spaf\Library\Code\Xml\Node Parent node
	 * @return boolean
	 */
	public function setParentNode(\Spaf\Library\Code\Xml\Node $parentNode) {
		$this->_parentNode = $parentNode;

		// fix indent
		$this->setIndent($this->_parentNode->getIndent() + 1);
		// fix is root property to be sure, a node with a parent cannot defently not be the root node
		$this->_isRoot = false;
		// fix document if set for parent node
		if ($this->_parentNode->getDocument() !== null) {
			$this->setDocument($this->_parentNode->getDocument());
		}

		return true;
	}

	/**
	 * Add a attribute to this node.
	 *
	 * @param string Key of the attribute
	 * @param string Value of the attribute
	 * @return boolean True
	 */
	public function addAttribute($key, $value) {
		$this->_attributes[$key] = $value;

		return true;
	}

	/**
	 * Remove a attribute from this node
	 *
	 * @param string Key of the attribute to remoe
	 * @return boolean True or false if the attribute was not found
	 */
	public function removeAttribute($key) {
		if (isset($this->_attributes[$key])) {
			unset($this->_attributes[$key]);

			return true;
		}

		return false;
	}

	/**
	 * Add child node and set $this as its parent.
	 * And it sets the node content to null,
	 * since a node cannot have content and children
	 * at once.
	 *
	 * @param \Spaf\Library\Code\Xml\Node
	 * @return boolean True
	 */
	public function addChild(\Spaf\Library\Code\Xml\Node $node) {
		$this->_value = null;

		$node->setParentNode($this);
		array_push($this->_children, $node);

		return true;
	}

	/**
	 * Remove a child node from this node.
	 *
	 * @param \Spaf\Library\Code\Xml\Node Child node to remove
	 */
	public function removeChild(\Spaf\Library\Code\Xml\Node $node) {
		foreach ($this->_children as $key => $child) {
			if ($child === $node) {
				unset($this->_children[$key]);
			}
		}
	}

	/**
	 * Remove this node from its parent
	 *
	 * @return boolean True if node is successful removed, otherwise false
	 */
	public function remove() {
		return $this->_parent->removeChild($this);
	}

	public function getName() {
		return $this->_name;
	}

	public function getChildren() {
		return $this->_children;
	}

	public function getAttributes() {
		return $this->_attributes;
	}

	public function getValue() {
		return $this->_value;
	}

	public function toString() {
		$flushSelf = false;
		$writer = $this->_document->getWriter();

		// if no document set yet, means you want to render the node by itself
		if ($writer === null) {
			$writer = new \XMLWriter();
			$writer->openMemory();
			$flushSelf = true;
		}

		// \XMLWriter adds a newline for doctype but nothing else
		if ($this->_isRoot === false) {
			$writer->text("\n");
		}

		$writer->text(str_repeat($this->_indentString, $this->_indent));
		$writer->startElement($this->getName());

		foreach ($this->getAttributes() as $key => $attribute) {
			$writer->startAttribute($key);
			$writer->text($attribute);
			$writer->endAttribute();
		}
		//echo 'start element ' . $this->getName() . "\n";
		if (count($this->getChildren()) > 0) {
			foreach ($this->getChildren() as $childNode) {
				$childNode->toString($writer);
			}
		} else if ($this->getValue() !== null) {
			$writer->text("\n");
			$writer->text(str_repeat($this->_indentString, $this->_indent + 1));
			$writer->text($this->getValue());
		}

		//echo 'end element ' . $this->getName() . "\n";
		$writer->text("\n");
		$writer->text(str_repeat($this->_indentString, $this->_indent));
		$writer->endElement();

		if ($flushSelf === true) {
			return $writer->flush();
		}

		return true;
	}

	public function __toString() {
		return $this->toString();
	}
}

?>