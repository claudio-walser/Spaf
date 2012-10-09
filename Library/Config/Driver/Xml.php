<?php

/**
 * ConfigDriverXml.php :: Konfigurations Dateien im XML Format lesen und schreiben
 *
 * Die Klasse ConfigDriverXml stellt die Schnittstelle bereit um .xml Dateien zu schreiben und zu lesen.
 *
 * @category	Config
 * @package		Config
 * @subpackage	ConfigDrivers
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class ConfigDriverXml extends ConfigDriver {


    /**
     * Endung der Datei
	 *
	 * Die Dateiendung dieses Treibertyps ist hier gespeichert.
     *
     * @var		string
     * @access	private
     */
	private $_fileExtension = 'xml';

    /**
     * Dateiname
	 *
	 * Der Dateiname wird hier abgelegt sobald sie mit Config::registerDriver()
	 * eine Ini Datei angegeben haben.
     *
     * @var		string
     * @access	private
     */
	private $_fileName = null;


	/**
	 * Konstruktor
	 *
	 * Generiert eine valide Dateiendung falls nötig
	 * und speichert den Namen in einer Klassenvariable.
	 *
     * @access	public
     * @param	string			Name der Konfigurations Datei
	 */
	public function __construct($file_name) {
		if (substr($file_name, -(strlen($this->_fileExtension) + 1)) !== '.' . $this->_fileExtension) {
			$file_name .= '.' . $this->_fileExtension;
		}
		$this->_fileName = $file_name;
	}


	/**
	 * XML Dateien lesen
	 *
	 * Funktion um eine XML Datei zu parsen und die Konfigurations-
	 * Variablen in einem assoziativen Array zurückzugeben.
	 *
     * @access	public
     * @return	array			Komplette Daten der Konfiguration
	 */
	public function read() {
		$array['comments'] = null;
		if (is_file($this->_fileName)) {
			$xml_string = file_get_contents($this->_fileName);
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
						$array['data'][$section_name][$element['attributes']['NAME']] = empty($element['value']) ? 'empty' : $element['value'];
						break;

					default:
						break;

				}
			}
			if (!is_array($array['data']) || empty($array['data'])) {
				$array['data'] = null;
			}
		} else {
			$array['data'] = null;
		}
		return $array;
	}


	/**
	 * XML Dateien schreiben
	 *
	 * Funktion um eine XML Datei zu schreiben. Als Parameter
	 * wird das komplette zu schreibende Array erwartet.
	 *
     * @access	public
	 * @param	array			Komplette Daten der Konfiguration
     * @return	bool
	 */
	public function save(Array $assoc_array) {
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
		file_put_contents($this->_fileName, $file_content);
		return true;
	}

}


?>