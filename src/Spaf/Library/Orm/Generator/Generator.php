<?php
/**
 * $Id$
 * ORM main generator class
 *
 * @created 	Tue Jun 08 19:24:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Cwa\Library\Directory
 * @namespace	\Cwa\Library\Directory
 */

namespace Cwa\Library\Orm\Generator;


/**
 * \Cwa\Library\Orm\Generator
 *
 * The generator class is the mian interface
 * to connect. Internally it decides which
 * Model/Query generator it should take
 *
 * @author 		Claudio Walser
 */
class Generator {

	/**
	 * The xml source file.
	 *
	 * @var		\Cwa\Library\Directory\File
	 */
	private $_xmlFile = null;

	/**
	 * Target path for the model classes
	 *
	 * @todo	store a directory object
	 * @var		string
	 */
	private $_targetPathModel = null;

	/**
	 * Target path for the setup query
	 *
	 * @todo	store a directory object
	 * @var		string
	 */
	private $_targetPathSetup = null;

	/**
	 * You want generate the model?
	 *
	 * @var		boolean
	 */
	private $_generateModel = true;

	/**
	 * You want generate the setup?
	 *
	 * @var		boolean
	 */
	private $_generateSetup = true;

	/**
	 * PHP Version of the model? Possible values are 5 and 6
	 * were 5 is without and 6 is with namespaces
	 *
	 * @var		integer
	 */
	private $_phpVersion = 5;

	/**
	 * SQL Version of the model? Possible values are 4 and 5
	 * were 4 is without and 5 is with constaints
	 *
	 * @var		integer
	 */
	private $_sqlVersion = 4;

	/**
	 * In what namespace your model should be generated?
	 * Only needed for php6
	 *
	 * @var		string
	 */
	private $_modelNamespace = null;

	/**
	 * In what namespace are your runtime classes?
	 * Only needed for php5
	 *
	 * @var		string
	 */
	private $_runtimeNamespace = null;

	/**
	 * Set the xml file.
	 * Sets a File object as xml source
	 *
	 * @author		Claudio Walser
	 * @param		\Cwa\Library\Directory\File			The XML source file
	 * @return		boolean
	 */
	public function setXmlFile(\Cwa\Library\Directory\File $xmlFile) {
		$this->_xmlFile = $xmlFile;
		return true;
	}

	/**
	 * Get the xml file.
	 * Gets the xml source File object
	 *
	 * @author		Claudio Walser
	 * @return		\Cwa\Library\Directory\File
	 */
	public function getXmlFile() {
		return $this->_xmlFile;
	}

	/**
	 * Set a target path for model classes.
	 * Gets the xml source File object
	 *
	 * @author		Claudio Walser
	 * @return		bool
	 */
	public function setTargetPathModel($targetPath) {
		$this->_targetPathModel = $targetPath;
	}

	public function getTargetPathModel() {
		return $this->_targetPathModel;
	}

	public function setTargetPathSetup($targetPath) {
		$this->_targetPathSetup = $targetPath;
	}

	public function getTargetPathSetup() {
		return $this->_targetPathSetup;
	}

	public function setGenerateModel($bool) {
		$this->_generateModel = (bool) $bool;
	}

	public function getGenerateModel() {
		return $this->_generateModel;
	}

	public function setGenerateSetup($bool) {
		$this->_generateSetup = (bool) $bool;
	}

	public function getGenerateSetup() {
		return $this->_generateSetup;
	}

	public function setPhpVersion($version) {
		$this->_phpVersion = (int) $version;
	}

	public function getPhpVersion() {
		return $this->_phpVersion;
	}

	public function setSqlVersion($version) {
		$this->_sqlVersion = $version;
	}

	public function getSqlVersion() {
		return $this->_sqlVersion;
	}
	
	public function setModelNamespace($namespace) {
		$this->_modelNamespace = (string) $namespace;
	}
	
	public function getModelNamespace() {
		return $this->_modelNamespace;
	}
	
	public function setRuntimeNamespace($namespace) {
		$this->_runtimeNamespace = (string) $namespace;
	}
	
	public function getRuntimeNamespace() {
		return $this->_runtimeNamespace;
	}
	
	public function generate() {
		// instantiate the parser for lazy sheme xml, with lazy defined relations
		$parser = new Parser\Xml($this->getXmlFile());
		// parse the xml model into a array with table objects and their relations
		$model = $parser->getObjects();
				
		$this->_generateModel($model);
		$this->_generateSetup($model);
	}
	
	protected function _generateSetup($model) {
		if ($this->getGenerateSetup() === false) {
			return false;
		}
		// instantiate the query generator for the setup query
		$sq = new Query\Setup($model, $this->getSqlVersion());
		$sq->saveSetup($this->getTargetPathSetup());
		// do it
	}
	
	protected function _generateModel($model) {
		if ($this->getGenerateModel() === false) {
			return false;
		}
		// do it
		// instantiate the model generator
		$mg = Model\Factory::create($model, $this->getTargetPathModel(), $this->getPhpVersion());
		$mg->setModelNamespace($this->getModelNamespace());
		$mg->setRuntimeNamespace($this->getRuntimeNamespace());
		$mg->generateModel();
	}
}