<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Xml.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Xml
 *
 * Concrete driver class to handle xml configs.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Xml extends Abstraction {

	/**
	 * Read the current given xml file.
	 *
	 * @throws \Spaf\Library\Config\Driver\Exception Throws an exception if no source file is set yet
	 * @access public
	 * @return array Nested array of the whole config
	 */
	public function read() {
		$array = array();

		$xml_string = $this->_sourceFile->getContent();
		$document = new \Spaf\Library\Code\Xml\Document();
		$document->fromString($xml_string);
		$rootNode = $document->getRootNode();

		foreach ($rootNode->getChildren() as $child) {
			$array[$child->getName()] = array();
			foreach ($child->getChildren() as $subchild) {
				$array[$child->getName()][$subchild->getName()] = $subchild->getValue();
			}
		}

		return array('data' => $array);
	}

	/**
	 * Write the config back to the xml file currently set.
	 *
	 * @param array Nested array with complete config to write
	 * @return bool True if writing the file was successfull
	 */
	public function save(Array $assoc_array, $filename = null) {
		parent::save($assoc_array, $filename);
		$assoc_array = $assoc_array['data'];

		$document = new \Spaf\Library\Code\Xml\Document();

		$rootNode = new \Spaf\Library\Code\Xml\Node('config');
		$document->setRootNode($rootNode);

		foreach ($assoc_array as $section => $section_array) {
			$sectionNode = new \Spaf\Library\Code\Xml\Node($section);
			$rootNode->addChild($sectionNode);

			if (is_array($section_array)) {
				foreach ($section_array as $key => $value) {
					$childNode = new \Spaf\Library\Code\Xml\Node($key);
					$childNode->setValue($value);
					$sectionNode->addChild($childNode);
				}
			}
		}

		$this->_sourceFile->setContent($document->toString());

		return $this->_sourceFile->write($filename);
	}

}

?>