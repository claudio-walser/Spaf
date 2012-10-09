<?php

 /**
 * $Id$
 *
 * Spaf/Library/Config/Driver/Abstraction.php
 * @created Sat Sep 09 09:33:02 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config\Driver;

/**
 * \Spaf\Library\Config\Driver\Abstraction
 *
 * Concrete driver class to handle ini configs.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config\Driver
 * @namespace Spaf\Library\Config\Driver
 */
class Ini extends Abstraction {


    /**
     * File extension.
     *
     * @var string
     * /
	private $_fileExtension = 'ini';

    /**
     * How a comment line has to start
	 *
     * @var string
     * /
	private $_commentPrefix = ';';

    /**
     * How a comment line has to end
     *
     * @var string
     * /
	private $_commentSuffix = '';

	/**
	 * INI Dateien lesen
	 *
	 * Funktion um eine INI Datei zu parsen und die Konfigurations-
	 * Variablen in einem assoziativen Array zur�ckzugeben.
	 *
     * @access	public
     * @return	array			Komplette Daten der Konfiguration
	 */
	public function read() {
		if ($this->_sourceFile === null) {
			throw new Exception('Set a source file before read');
		}

		$array['data'] = parse_ini_file($this->_file->getPath() . $this->_file->getName(), 1);

		if (!is_array($array) || empty($array)) {
			$array['data'] = null;
		}

		return $array;
	}


	/**
	 * Write the config back to the ini file currently set.
	 *
	 * @param array Nested array with complete config to write
     * @return bool True if writing the file was successfull
	 */
	public function save(Array $assoc_array) {
		$assoc_array = $assoc_array['data'];
		$file_content = '';
		foreach ($assoc_array as $section => $section_array) {
			if (is_array($section_array)) {
				$file_content .= '[' . $section . ']' . "\n";
				foreach ($section_array as $key => $value) {
					if ($value === false) {
						$value = 'false';
					} else if ($value === true){
						$value = 'true';
					} else if ($value === null){
						$value = 'null';
					}
					$file_content .= $key . ' = ' . $value . "\n";
				}
			}
			$file_content .= "\n";
		}
		$this->_sourceFile->setContent($file_content);
		return $this->_sourceFile->write();
	}


}
?>