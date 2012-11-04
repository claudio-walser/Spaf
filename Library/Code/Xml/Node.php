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
 * @todo This class is awefully big, see how to optimize, maybe traits maybe extensions as Cdata extends Node and Trait for Attributes, not quite sure yet, think about it
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml
 * @namespace Spaf\Library\Code\Xml
 */
class Node {

	/**
	 * Trait to write Objects to a XML String
	 *
	 * @var \Spaf\Library\Code\Xml\Node\Writer
	 */
	use Node\Writer;

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

	/**
	 * Parent document object for this node.
	 *
	 * @var \Spaf\Library\Code\Xml\Document
	 */
	private $_document = null;

	/**
	 * True if this is the root node.
	 * Note, any valid XHTML or XML Document can only contain one root node.
	 *
	 * @var boolean
	 */
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

	/**
	 * Set a document object
	 *
	 * @param \Spaf\Library\Code\Xml\Document The document you want to set as parent
	 * @return boolean True
	 */
	public function setDocument(\Spaf\Library\Code\Xml\Document $document) {
		$this->_document = $document;
		foreach ($this->getChildren() as $childNode) {
			$childNode->setDocument($this->_document);
		}
		return true;
	}

	/**
	 * Get the current document object
	 *
	 * @return \Spaf\Library\Code\Xml\Document The current Document object
	 */
	public function getDocument() {
		return $this->_document;
	}

	/**
	 * Get and Set for isRoot in one.
	 * Get the value if you dont pass anything to this function.
	 * Change it by passing a boolean.
	 *
	 * @todo Hm, i think this is buggy
	 * @todo Put this in normal getter and setter that 1. everybody can understand it, 2. i can normaly document it
	 * @this Is crap right now
	 */
	public function isRoot($boolean = null) {
		if ($boolean === null) {
			$boolean = $this->_isRoot;
		}

		$this->_isRoot = (bool) $boolean;

		// @buggy Probably buggy, isnt it? What the hell did i thought, at 4 o clock in the morning :-P
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

	/**
	 * Get current name of this node
	 *
	 * @return string Name of this node
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * Get children of this node
	 *
	 * @return array Array with children Node objects in it
	 */
	public function getChildren() {
		return $this->_children;
	}

	/**
	 * Get attributes of this node
	 *
	 * @return array Simple Key=>Value array with all attributes of this node
	 */
	public function getAttributes() {
		return $this->_attributes;
	}

	/**
	 * Get current value of this node
	 *
	 * @return string Node Value
	 */
	public function getValue() {
		return $this->_value;
	}

}

?>