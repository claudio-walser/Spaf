<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Php.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Php
 *
 * Concrete driver class to handle php configs.
 * Any php config file is simply included,
 * and should contain a $config array definition.
 *
 * @todo Implement config comments
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Php extends Abstraction {

	/**
	 * Read the current given php file.
	 *
	 * @throws \Spaf\Library\Config\Driver\Exception Throws an exception if no source file is set yet
     * @access public
     * @return array Nested array of the whole config
	 */
	public function read() {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}

		include($this->_sourceFile->getPath() . $this->_sourceFile->getName());

		if (!isset($config)) {
			$config = null;
		}

		$array = array(
			'data' => $config
		);

		return $array;

	}

	/**
	 * Write the config back to the php file currently set.
	 *
	 * @param array Nested array with complete config to write
     * @return bool True if writing the file was successfull
	 */
	public function save(Array $assoc_array) {
		$assoc_array = $assoc_array['data'];
		$file_content = '<?php' . "\n\n";
		foreach ($assoc_array as $section => $section_array) {

			if (is_array($section_array)) {
				foreach ($section_array as $key => $value) {
					foreach ($this->_toEscape as $char_to_escape) {
						$value = str_replace($char_to_escape, $char_to_escape . '\\', $value);
					}
					if ($value === false) {
						$value = 'false';
					} else if ($value === null) {
						$value = 'null';
					}
					if (is_numeric($value) || in_array($value, $this->_allowedToStrip)) {
						$file_content .= '$config[\'' . $section . '\'][\'' . $key . '\'] = ' . $value . ';' . "\n";
					} else {
						$file_content .= '$config[\'' . $section . '\'][\'' . $key . '\'] = \'' . $value . '\';' . "\n";
					}

				}
			}
			$file_content .= "\n";
		}
		$file_content .= '?>';

		$this->_sourceFile->setContent($file_content);
		return $this->_sourceFile->write();
	}

}

?>