<?php

/**
 * $ID$
 *
 * Spaf/Library/Code/Xml/Node/Writer.php
 * @created Sun Nov 04 10:32:58 +0200 2012
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Code\Xml\Node;


/**
 * \Spaf\Library\Code\Xml\Node\Writer
 *
 * Trait for write an XML/Node to string
 *
 * @author Claudio Walser
 * @package Spaf\Library\Code\Xml\Node
 * @namespace Spaf\Library\Code\Xml\Node
 */
trait Writer {

	/**
	 * Parse the node into an XMLWriter object to a string
	 *
	 * @todo Optimize this, maybe the writer should be passed as param from document and flushed every time here, think about it
	 * @return mixed String if you want to ouptut the node directly, boolean if its called by outputting the document
	 */
	public function toString() {
		$flushSelf = false;
		//@buggy Guess its only parsing a single node if no document is set now
		$writer = $this->_document->getWriter();

		// if no document set yet, means you want to render the node by itself
		if ($writer === null) {
			//@buggy Guess its only parsing a single node if no document is set now
			//@fix One fix would be to set the writer here to the current node over method and also pass the same writer to all child instances
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
				//@buggy Guess its only parsing a single node if no document is set now
				$childNode->toString();
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