<?php

/**
 * ConfigDriverPhp.php :: Konfigurations Dateien im PHP Format lesen und schreiben
 *
 * Die Klasse ConfigDriverPhp stellt die Schnittstelle bereit um .php Dateien zu schreiben und zu lesen.
 * Dabei wird ein Array in nativem PHP Code gespeichert und zum auslesen schlicht includiert.
 * Dieser Treiber liest die Konfiguration am performantesten aus.
 *
 * @category	Config
 * @package		Config
 * @subpackage	ConfigDrivers
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class ConfigDriverPhp extends ConfigDriver {


    /**
     * Endung der Datei
	 *
	 * Die Dateiendung dieses Treibertyps ist hier gespeichert.
     *
     * @var		string
     * @access	private
     */
	private $_fileExtension = 'php';

    /**
     * keine Strings
	 *
	 * true, false und null werden als Datentypen erkennt und nicht als Strings
	 * in die Konfigurationsdatei geschrieben.
     *
     * @var		array
     * @access	private
     */
	private $_allowedToStrip = array('true', 'false', 'null');

    /**
     * zu maskierende Zeichen
	 *
	 * Alle Zeichen die maskiert werden.
     *
     * @var		array
     * @access	private
     */
	private $_toEscape = array('\\');

    /**
     * Dateiname
	 *
	 * Der Dateiname wird hier abgelegt sobald sie mit Config::registerDriver()
	 * eine Ini Datei angegeben haben.
     *
     * @var		string
     * @access	private
     */
	private $_fileName      = null;


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
	 * PHP Dateien lesen
	 *
	 * Funktion um eine PHP Datei einzubinden. Das Array im ConfigFile
	 * muss $config heissen, da es schlicht nur includiert werden.
	 *
     * @access	public
     * @return	array			Komplette Daten der Konfiguration
	 */
	public function read() {
		if (is_file($this->_fileName)) {
			include($this->_fileName);
		} else {
			$config = null;
		}
		$config['data'] = $config;
		return $config;
	}


	/**
	 * PHP Dateien schreiben
	 *
	 * Funktion um eine PHP Datei zu schreiben. Als Parameter
	 * wird das komplette zu schreibende Array erwartet.
	 *
     * @access	public
	 * @param	array			Komplette Daten der Konfiguration
     * @return	bool
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
		file_put_contents($this->_fileName, $file_content);
		return true;
	}

}


?>