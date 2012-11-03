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
	 * Content of this node,
	 * its set to null as soon as
	 * you add a child node.
	 */
	private $_content = null;

	/**
	 * Node Attributes as key/value array
	 *
	 * @var array
	 */
	private $_attribtes = array();

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
	 * Store the node name.
	 *
	 * @param string Node name
	 * @return void
	 */
	public function __construct($name = 'node') {
		$this->_name = (string) $name;
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
	public function addChild(\Spaf\Library\Code\Xml\Node $noe) {
		$this->_content = null;

		$node->setParent($this);
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

}

?>