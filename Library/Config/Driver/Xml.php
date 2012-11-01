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
		$xml_string = $this->_sourceFile->getContent();
		$parser = xml_parser_create();
		xml_parse_into_struct($parser, $xml_string, $values);
		xml_parser_free($parser);

		$section_name = '';
		$array = array();
		foreach ($values as $element) {
			switch ($element['tag']) {

				case 'SECTION':
					if ($element['type'] == 'open') {
						$section_name = $element['attributes']['NAME'];
					}
					break;

				case 'PARA':
					$array[$section_name][$element['attributes']['NAME']] = empty($element['value']) ? 'empty' : $element['value'];
					break;

				default:
					break;

			}
		}

		if (!is_array($array) || empty($array)) {
			$array = array();
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
		$assoc_array = $assoc_array['data'];
		$file_content  = '<?xml version=\'1.0\'?>' . "\n";
		$file_content .= '<config>' . "\n\n";
		foreach ($assoc_array as $section => $section_array) {
			$file_content .= '    <section name="' . $section . '">' . "\n";
			if (is_array($section_array)) {
				foreach ($section_array as $key => $value) {
					if ($value === false) {
						$value = 'false';
					} else if ($value === true){
						$value = 'true';
					} else if ($value === null){
						$value = 'null';
					}
					$file_content .= '        <para name="' . $key . '">' . $value . '</para>' . "\n";
				}
				$file_content .= '    </section>' . "\n\n";
			}
		}
		$file_content .= '</config>';

		$this->_sourceFile->setContent($file_content);

		return $this->_sourceFile->write($filename);
	}

}

?>