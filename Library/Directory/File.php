<?php

/**
 * $Id$
 *
 * Spaf/Library/Directory/File.php
 * @created Tue Jun 08 19:24:27 CET 2010
 * @author Claudio Walser
 * @reviewer TODO
 */
 namespace Spaf\Library\Directory;

/**
 * \Spaf\Library\Directory\File
 *
 * The File class represents a file object and
 * gives you some functionanlity like
 * read content, copy, delete and some other
 * functionality.
 *
 * @author Claudio Walser
 * @package Spaf\Library\Directory
 * @namespace Spaf\Library\Directory
 */
class File extends Abstraction {

	/**
	 * The file name without paths.
	 *
	 * @var string
	 */
	private $_name = null;

	/**
	 * The file path without name.
	 *
	 * @var string
	 */
	private $_path = null;

	/**
	 * Defines if a file is already deleted or not.
	 *
	 * @var boolean
	 */
	private $_deleted = false;

	/**
	 * Defines if the source file is in utf-8 or not.
	 *
	 * @var string
	 */
	private $_utf8Decode = false;

	/**
	 * Content as an array with each line
	 *
	 * @var array Content as an array with each line
	 */
	private $_lines = null;

	/**
	 * Content as string
	 *
	 * @var string Content as string
	 */
	private $_content = null;


	/**
	 * Splits the path in filename and filepath.
	 *
	 * @param string Path to the directory
	 * @return boolean
	 */
	public function __construct($file) {
		$file = self::formPath($file, false);

		if (!is_readable($file)) {
			throw new Exception('File �' . $file . '� does not exists!');
		}

		$parts = $this->_getNameAndPath($file);

		$this->_name = $parts['name'];
		$this->_path = $parts['path'];
	}

	/**
	 * Get name of the file.
	 * Returns the file name without the path.
	 *
	 * @return string Name of the file without it's path
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * Get path of the file.
	 * Returns the file path without the name.
	 *
	 * @return string Path of a file without its name
	 */
	public function getPath() {
		return $this->_path;
	}

	/**
	 * Get content of the file.
	 * Be carefull by writing back
	 * utf-8 content.
	 * Use fopen(*, 'wb') for binary strings.
	 *
	 * @return string
	 */
	public function getContent() {
		if ($this->_content === null) {
			$this->_content = file_get_contents($this->_path . $this->_name);
		}

		return $this->_content;
	}

	/**
	 * Get an array of lines from the current file
	 *
	 * @return array Array with all lines of this file
	 */
	public function getLines() {
		if ($this->_lines === null) {
			$this->_lines = file($this->_path . $this->_name);
		}

		return $this->_lines;
	}

	/**
	 * Set the content for this file.
	 * This is only usefull if you going to write
	 * it as well i guess.
	 * This is also updating $this->_lines
	 *
	 * @param string Content to write into the file
	 * @return boolean True
	 */
	public function setContent($content) {
		$this->_content = (string) $content;
		$this->_lines = explode("\n", $this->_content);

		return true;
	}

	/**
	 * Set the an array as current lines.
	 * This is only usefull if you going to write
	 * it as well i guess.
	 * This is also updating $this->_content
	 *
	 * @param array Array with lines to write into the file
	 * @return boolean True
	 */
	public function setLines(array $lines) {
		$this->_lines = $lines;
		$this->_content = implode("\n", $this->_lines);
	}

	/**
	 * Write the file to the harddisk.
	 *
	 * @throws \Spaf\Library\Directory\Exception Throws an Exception if it was not possible to write the file
	 * @param string Filename if you want copy the file
	 * @param boolean True for saving binary content, default to false
	 * @return boolean True if the file was successfully written
	 */
	public function write($file = null, $binary = false) {
		if ($file === null) {
			$file = $this->_path . $this->_name;
		}

		$parts = $this->_getNameAndPath($file);
		$name = $parts['name'];
		$path = $parts['path'];

		\Spaf\Library\Directory\Abstraction::createDirectory($path);
		if (!file_put_contents($file, $this->_content)) {
			throw new Exception('Could not write file: ' . $file);
		}

		return true;
	}

	/**
	 * Splits the name and path of a given folder-path.
	 *
	 * @param string Folderpath
	 * @return array Array with name and path seperated
	 */
	private function _getNameAndPath($namePath) {
		$namePath = self::formPath($namePath, false);
		$parts = explode('/', $namePath);

		$name = array_pop($parts);
		$path = self::formPath(implode('/', $parts));

		return array('path' => $path, 'name' => $name);
	}












	/**
	 * Legacy Stuff from here, might have some usefull stuff maybe...
	 */

	/**
	 * Bestimmt ob jegliche Dateinamen mit einem UTF-8 Decode behandelt werden.
	 *
	 * FileObject::setUtf8Decode() ben�tigt ben�tigt einen Boolean als Parameter.
	 *
	 * @access	public
	 * @return	string			Verzeichnisname
	 * /
	public function setUtf8Decode($bool = false) {
		$this->_utf8Decode = (bool) $bool;
		return true;
	}

	/**
	 * Liefert den Dateinamen
	 *
	 * FileObject::getName() ben�tigt keine Parameter und liefert den Dateinamen ohne Pfad.
	 *
	 * @access	public
	 * @return	string			Verzeichnisname
	 * /
	public function getName() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return $this->_fileName;
	}

	/**
	 * Liefert den Dateipfad
	 *
	 * FileObject::getPath() ben�tigt keine Parameter und liefert den Dateipfad ohne den Namen.
	 *
	 * @access	public
	 * @return	string			Verzeichnisname
	 * /
	public function getPath() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return $this->_path;
	}

	/**
	 * Liefert den Dateipfad
	 *
	 * FileObject::getPath() ben�tigt keine Parameter und liefert den Dateipfad ohne den Namen.
	 *
	 * @access	public
	 * @return	string			Verzeichnisname
	 * /
	public function getFullPath() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return $this->_fullPath;
	}

	/**
	 * Liefert das Datum der letzen �nderung
	 *
	 * Dir::getPath() ben�tigt keine Parameter und liefert den Vezeichnispfad ohne den Namen.
	 *
	 * @access	public
	 * @return	string			Verzeichnisname
	 * /
	public function getLastModified() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted directory object!');
		}
		return filemtime($this->_fullPath);
	}

	/**
	 * Ermittelt die Dateiendung
	 *
	 * Die Dateiendung der Datei wird zur�ckgegeben.
	 *
	 * @access	public
	 * @return	string			Bekannte Dateiendung oder 'unknown'
	 * /
	public function getExtension() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		$info = pathinfo($this->_fullPath);
		return isset($info['extension']) ? strtolower($info['extension']) : 'unknown';
	}

	/**
	 * Ermittelt einige Dateiinformationen
	 *
	 * Genauer gesagt wird hier die PHP Funktion stat aufgerufen.
	 * Die R�ckgabewerte sind genau unter<br />
	 * <i>http://www.php.net/manual/de/function.stat.php</i><br />
	 * beschrieben.
	 *
	 * @throws	DirException	File does not exist Exception
	 * @access	public
	 * @param 	string			Dateiname mit Pfad
	 * @return	array			Assoziatives Array mit allen Infos der Datei
	 * /
	public function getInfo() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return stat($this->_fullPath) !== false ? stat($this->_fullPath) : null;
	}

	/**
	 * Den MimeType einer Datei ermitteln
	 *
	 * Gibt den genauen MimeType einer Datei wieder. Dies kann zum Beispiel
	 * f�r das Zusammenbauen von Mail Headern sehr hilfreich sein.<br />
	 * <b>Warnung:</b><br /><i>Die Datei muss existieren.</i>
	 *
	 * @throws	FileException	File does not exist Exception
	 * @access	public
	 * @param 	string			Dateiname mit Pfad
	 * @return	bool
	 * /
	public function getMimeType() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return mime_content_type($this->_fullPath);
	}

	/**
	 * Dateigr�sse ermitteln
	 *
	 * Mithilfe dieser Funktion kann die genaue Dateigr�sse
	 * ermittelt werden. Diese erh�lt man als R�ckgabe der Funktion
	 * als String in der Form "Gr�sse Einheit".
	 * Also zum Beispiel 19.50 MB
	 *
	 * @throws	FileException	If deleted Exception
	 * @access	public
	 * @param 	string			Dateiname mit Pfad
	 * @return	string			Gr�sse der Datei entsprchend formatiert
	 * /
	public function getFileSize($decimal = 2) {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		$size = $this->getBytes();
		return $size;
		if ($size < 1000) {
			return number_format($size, 0, ",", "`")." Bytes";
		} else if ($size < 1000000) {
			return number_format($size/1024, $decimal, ",", "`")." KB";
		} else if ($size < 1000000000) {
			return number_format($size/1048576, $decimal, ",", "`")." MB";
		} else {
			return number_format($size/1073741824, $decimal, ",", "`")." GB";
		}
	}

	/**
	 * Dateigr�sse in bytes ermitteln
	 *
	 * Mithilfe dieser Funktion kann die genaue Dateigr�sse in Bytes
	 * ermittelt werden.
	 * Die R�ckgabe der Funktion ist ein Integer Wert mit Anzahl der Bytes.
	 *
	 * @throws	FileException	If deleted Exception
	 * @access	public
	 * @return	int				Gr�sse der Datei in Bytes
	 * /
	public function getBytes() {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		return filesize($this->_fullPath);
	}

	/**
	 * Datei umbenennen
	 *
	 * Diese Methode setzt einen neuen Namen f�r die Datei.
	 * Wirft eine Ausnahem wenn eine Datei mit dem neuen Namen bereits besteht.
	 *
	 * @throws	FileException	File does already exist Exception
	 * @throws	FileException	Cannot rename file Exception
	 * @access	public
	 * @param 	string			Neuer Dateiname
	 * /
	 public function rename($newName) {
		if ($this->_deleted !== false) {
			throw new FileException('Cant process any operations on a deleted file object!');
		}
		if (file_exists($this->_path . $newName)) {
			throw new FileException('File �' . $newName . '� does already exists!');
		}
		if (!rename($this->_fullPath, $this->_path . $newName)) {
			throw new FileException('Cannot rename file �' . $this->_name . '�!');
		}

		$this->_fileName = $newName;
		$this->_fullPath = $this->_path . $this->_fileName;
		//touch($this->_fullPath, time());

		return true;
	}

	public function copy($target) {
		if (!copy($this->_fullPath, Dir::formPath($target) . $this->_fileName)) {
			throw new FileException('Cant copy the file ' . $this->_fileName . ' to target: ' . Dir::formPath($target) . '!');
		}
		$this->_path = Dir::formPath($target);
		$this->_fullPath = $this->_path . $this->_fileName;
		return true;
	}

	public function move($target) {
		$oldFileName = $this->_fullPath;
		$this->copy($target);
		unlink($oldFileName);
		return true;
	}

	/**
	 * Datei l�schen
	 *
	 * Diese Methode l�scht die Datei.
	 *
	 * @throws	FileException	Cannot delete file Exception
	 * @access	public
	 * /
	 public function delete() {
		if (!is_file($this->_fullPath) || !unlink($this->_fullPath)) {
			throw new FileException('Cannot delete file �' . $this->_fullPath . '�!');
		}
		$this->_deleted = true;
		return true;
	 }*/

}

?>