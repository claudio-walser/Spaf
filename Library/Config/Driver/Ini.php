<?php

/**
 * ConfigDriverIni.php :: Konfigurations Dateien im INI Format lesen und schreiben
 *
 * Die Klasse ConfigDriverIni stellt die Schnittstelle bereit um .ini Dateien zu schreiben und zu lesen.
 *
 * @category	Config
 * @package		Config
 * @subpackage	ConfigDrivers
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class ConfigDriverIni extends ConfigDriver {


    /**
     * Endung der Datei
	 *
	 * Die Dateiendung dieses Treibertyps ist hier gespeichert.
     *
     * @var		string
     * @access	private
     */
	private $_fileExtension = 'ini';

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
     * Kommentarpräfix
	 *
	 * Präfix für Kommentare. Beispielsweise <!--
     *
     * @var		string
     * @access	private
     */
	private $_commentPräfix	= ';';

    /**
     * Kommentarsuffix
	 *
	 * Suffix für Kommentare. Beispielsweise -->
     *
     * @var		string
     * @access	private
     */
	private $_commentSuffix	= '';


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
	 * INI Dateien lesen
	 *
	 * Funktion um eine INI Datei zu parsen und die Konfigurations-
	 * Variablen in einem assoziativen Array zurückzugeben.
	 *
     * @access	public
     * @return	array			Komplette Daten der Konfiguration
	 */
	public function read() {
		$array['comments'] = null;
		if (is_file($this->_fileName)) {
			$array['data'] = parse_ini_file($this->_fileName, 1);

			if (!is_array($array) || empty($array)) {
				$array['data'] = null;
			}
		} else {
			$array['data'] = null;
		}
		return $array;
	}


	/**
	 * INI Dateien schreiben
	 *
	 * Funktion um eine INI Datei zu schreiben. Als Parameter
	 * wird das komplette zu schreibende Array erwartet.
	 *
     * @access	public
	 * @param	array			Komplette Daten der Konfiguration
     * @return	bool
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

		file_put_contents($this->_fileName, $file_content);
		return true;
	}


}
?>