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
	 * Read the current given php file.
	 *
	 * @param \Spaf\Library\Directory\File Source file
	 * @return array Two dimensional config Array
	 */
	protected function _read(\Spaf\Library\Directory\File $file) {
		$array = array();

		$xml_string = $file->getContent();
		$document = new \Spaf\Library\Code\Xml\Document();
		$document->fromString($xml_string);
		$rootNode = $document->getRootNode();

		foreach ($rootNode->getChildren() as $child) {
			$array[$child->getName()] = array();
			foreach ($child->getChildren() as $subchild) {
				$array[$child->getName()][$subchild->getName()] = $subchild->getValue();
			}
		}

		return $array;
	}

	/**
	 * _write for php configuration files.
	 * 
	 * @param array Two dimensional array to write
	 * @param \Spaf\Library\Directory\File Source file
	 * @return boolean  Either true or false in case of an error
	 */
	protected function _write($array, \Spaf\Library\Directory\File $file) {
		$document = new \Spaf\Library\Code\Xml\Document();

		$rootNode = new \Spaf\Library\Code\Xml\Node('config');
		$document->setRootNode($rootNode);

		foreach ($array as $sectionName => $sectionArray) {
			$sectionNode = new \Spaf\Library\Code\Xml\Node($sectionName);
			$rootNode->addChild($sectionNode);

			if (is_array($sectionArray)) {
				foreach ($sectionArray as $key => $value) {
					$childNode = new \Spaf\Library\Code\Xml\Node($key);
					$childNode->setValue($value);
					$sectionNode->addChild($childNode);
				}
			}
		}

		$file->setContent($document->toString());

		return $file->write();
	}

}

?>