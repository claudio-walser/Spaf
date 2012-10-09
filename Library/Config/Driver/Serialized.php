<?php

/**
 * ConfigDriverSerialized.php :: Konfigurations Dateien als serialisiertes Array lesen und schreiben
 *
 * Die Klasse ConfigDriverSerialized stellt die Schnittstelle bereit um .srz Dateien zu schreiben und zu lesen.
 * Das Format dieser Dateien ist ledichlich ein von PHP serialisiertes Array.
 *
 * @category	Config
 * @package		Config
 * @subpackage	ConfigDrivers
 * @copyright	Copyright (c) 2006 Claudio Walser
 * @author		Claudio Walser
 */
class ConfigDriverSerialized extends ConfigDriver {


    /**
     * Endung der Datei
	 *
	 * Die Dateiendung dieses Treibertyps ist hier gespeichert.
     *
     * @var		string
     * @access	private
     */
	private $_fileExtension = 'srz';

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
	 * SRZ Dateien lesen
	 *
	 * Funktion um eine SRZ Datei zu parsen und die Konfigurations-
	 * Variablen in einem assoziativen Array zurückzugeben.
	 * Auch diese Funktion sollte relativ schnell arbeiten.
	 *
     * @access	public
     * @return	array			Komplette Daten der Konfiguration
	 */
	public function read() {
		$array['comments'] = null;
		if (is_file($this->_fileName)) {
			$content = file_get_contents($this->_fileName);
			$array['data'] = unserialize($content);
			if (!is_array($array) || empty($array)) {
				$array['data'] = null;
			}
		} else {
			$array['data'] = null;
		}
		return $array;
	}


	/**
	 * SRZ Dateien schreiben
	 *
	 * Funktion um eine SRZ Datei zu schreiben. Als Parameter
	 * wird das komplette zu schreibende Array erwartet.
	 * Dieser Treiber schreibt ConfigFiles am performantesten.
	 *
     * @access	public
	 * @param	array			Komplette Daten der Konfiguration
     * @return	bool
	 */
	public function save(Array $assoc_array) {
		$assoc_array = $assoc_array['data'];
		$file_content = serialize($assoc_array);
		file_put_contents($this->_fileName, $file_content);
		return true;
	}

}


?>