<?php

/**
 * $Id$
 *
 * Spaf/Library/Config/Manager.php
 * @created Sat Sep 09 08:17:23 CET 2006
 * @author Claudio Walser
 * @reviewer TODO
 */
namespace Spaf\Library\Config;

/**
 * \Spaf\Library\Config\Manager
 *
 * Unified interface for different types of config files.
 * Currently supported are: ini, xml, json, php (simple array) and a simple serialized format
 *
 * @author Claudio Walser
 * @package Spaf\Library\Config
 * @namespace Spaf\Library\Config
 */
class Manager {

    /**
     * The driver object
	 *
     * @var \Spaf\Library\Config\Driver\Abstraction
     */
	private $_driver = null;

    /**
     * Default driver to choose.
     *
     * @var string
     */
	private $_default = 'Driver\\Ini';

    /**
     * Current config file.
     *
     * @var \Spaf\Library\Directory\File
     */
	private $_configFile = null;

    /**
     * Data store for the config array.
     *
     * @var array
     */
	private $_storedData = null;

    /**
     * Register one of the driver type.
	 * Currently supported is ini, xml, json, php (simple array) and a simple serialized format
     *
     * @param string Driver type
     * @return boolean True
     */
	public function registerDriver($driver) {
		switch (strtoupper($driver)) {
			case 'ini':
				$this->_driver = new Driver\Ini();
				break;

			case 'xml':
				$this->_driver = new Driver\Xml();
				break;

			case 'php':
				$this->_driver = new Driver\Php();
				break;

			case 'json':
				$this->_driver = new Driver\Json();
				break;

			case 'serialized':
				$this->_driver = new Driver\Serialized();
				break;

			default:
				$this->_driver = new $this->_default();
				break;
		}

		return true;
	}

    /**
     * Read and also parse a config file.
     *
     * @throws \Spaf\Library\Config\Exception Throws an exception if no driver set yet
     * @return boolean True
     */
	public function read($file) {
		if ($this->_driver === null) {
			throw new Exception('You have to set a driver before call Config::read()');
		}
		$this->_storedData = $this->_driver->read($file);
		return true;
	}


    /**
     * Eine Sektion zur�ckgeben
     *
	 * Die Funktion kann benutzt werden um einzelne Sektionen auszulesen.
	 * Der Name der gew�nschten Sektion wird als String �bergeben.
     *
	 * @access	public
     * @param	string					Auszulesende Sektion
     * @return	mixed					NULL oder die Daten der gew�nschten Sektion
     */
	public function getSection($section) {
		if (is_array($this->_storedData['data']) && array_key_exists($section, $this->_storedData['data'])) {
			return $this->_storedData['data'][$section];
		} else {
			return null;
		}
	}


    /**
     * Definiert eine Sektion als Konstanten
     *
	 * Die Konfigurations Variablen einer Sektion werden hier als Konstanten definiert.
	 * Dabei wird der Array Schl�ssel als Name und das Value als Wert der Konstante verwendet.
     *
	 * @access	public
     * @param	string					Auszulesende Sektion
     * @return	bool
     */
	public function getSectionAsConstants($section) {
		$configs = $this->getSection($section);
		if ($configs !== null) {
			foreach ($configs as $key => $conf) {
				if (!defined($key)) {
					define($key, $conf);
				}
			}
		}
		return true;
	}


    /**
     * Gibt alle Sektionen zur�ck
     *
	 * Config::getAll kann verwendet werden um das ganze Konfiguartionsfile auszulesen.
	 * Zur�ck kommt ein 2-Dimensionales Array. In der ersten Dimension sind die Sektionsnamen
	 * als Schl�ssel und in der zweiten die Variablen mit Werten.
     *
	 * @access	public
     * @return	array					Assoziatives Array mit den Daten
     */
	public function getAll() {
		return $this->_storedData['data'];
	}


    /**
     * eine Sektion anlegen
     *
	 * Config::setSection kann eine neue Sektion anlegen oder eine bestehende
	 * �berschreiben.
     *
	 * @access	public
     * @param	array					Assoziatives Array mit den Daten
     * @param	string					Name der Sektion
     * @return	bool
     */
	public function setSection(Array $assoc_array, $section) {
		$this->_storedData['data'][$section] = $assoc_array;
		return true;
	}


    /**
     * eine Sektion l�schen
     *
	 * Config::deleteSection l�scht die gew�nschte Sektion aus dem internen Stapel.
     *
	 * @access	public
     * @param	string					Name der Sektion
     * @return	bool
     */
	public function deleteSection($section_name) {
		if (isset($this->_storedData['data'][$section_name])) {
			unset($this->_storedData['data'][$section_name]);
		}
		return true;
	}


    /**
     * alle Sektionen l�schen
     *
	 * Config::deleteAll l�scht alle Sektionen mit allen Konfigurations Variablen.
     *
	 * @access	public
     * @return	bool
     */
	public function deleteAll() {
		if (isset($this->_storedData)) {
			$this->_storedData = null;
		}
		return true;
	}


	/**
	 * alle Sektionen erstetzen
	 *
	 * Das komplette Konfigurations Array wird gel�scht und mit den neuen Daten
	 * beschrieben.
	 *
	 * @access	public
     * @param	array					Das assoziative Array. Namen als Schl�ssel
     * @return	bool
	 */
	public function setAll(Array $assoc_array) {
		$this->_storedData = $assoc_array;
		return true;
	}


	/**
	 * Die Konfigurationsdatei speichern
	 *
	 * Ruft die Speicherfunktion des ausgew�hlten Treibers aus und schreibt die Konfiguration
	 * in die angegebene Datei.<br /><br />
	 * <b>Warnung:</b><br /><i>Alle �nderungen an der Konfiguration werden immer erst in die Datei
	 * �bernommen, wenn Config::save() aufgerufen wurde.</i>
	 *
	 * @access	public
     * @return	bool
	 */
	public function save() {
		return $this->_driver->save($this->_storedData);
	}


	/**
	 * Alle vorhanden Sektionen auslesen
	 *
	 * Liest alle vorhandenen Sektionen aus. M�glicherweise kennt man diese w�hrend der Entwicklung nicht,
	 * weil zum Beispiel ein Arbeitskollege die Konfig erstellt. In solchen F�llen ist diese Funktion eventuell
	 * hilfreich.
	 *
	 * @access	public
     * @return	array				Array mit allen Sektionen
	 */
	public function getSections() {
		if ($this->_storedData['data'] !== null) {
			$array = array();
			foreach ($this->_storedData as $key => $data) {
				$array[] = $key;
			}
			if (empty($array)) {
				$array = null;
			}
		} else {
			$array = null;
		}
		return $array;
	}

}




?>