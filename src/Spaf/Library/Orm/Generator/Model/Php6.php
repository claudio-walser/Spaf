<?php

namespace Spaf\Library\Orm\Generator\Model;

/**
 * UdaModelGeneratorPhp5.php :: Generates the php5 model
 *
 * This class is the implemented generator for php 5 model classes.
 *
 * @abstract
 * @category	ModelGenerator
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */
class Php6 {

	/**
	 * Stores the array of UdaTables
	 * @access		protected
	 * @var			array
	 */
	protected $_meta = null;

	protected $_config = null;

	/**
	 * Path to the model templates
	 * @access		protected
	 * @var			string
	 */
	protected $_tplPath = null;

	/**
	 * Path where the generated model files will be saved
	 * @access		protected
	 * @var			array
	 */
	protected $_targetPath = null;

	protected $_runtimeNamespace = null;

	protected $_modelNamespace = null;

	/**
	 * constructor
	 *
	 * Instantiates the ModelGenerator
	 *
	 * The constructor stores the given parameters in own properties.
	 * There is a check if your given targetPath is a valid directory.
	 * Otherwise it will throw an Exception.
	 *
	 * @param		array		meta				Metainformation in form of an array includes UdaTable objects
	 * @param		string		targetPath 			Valid path to a directory where the model to save
	 * @throw		Exception		Throws an exception if the target path don't exists
	 * @access		public
	 */
	public function __construct($meta, $targetPath) {
		if (!is_dir($targetPath)) {
			throw new Exception('Can\'t find the model save path: ' . $targetPath);
		}

		$this->_meta = $meta['tables'];
		$this->_config = $meta['config'];
		$this->_allMeta = $meta;
		$this->_tplPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'Php6' . DIRECTORY_SEPARATOR;
		$this->_targetPath = $targetPath;

		if (!is_dir($this->_targetPath . 'Base')) {
			mkdir($this->_targetPath . 'Base', 0777);
		}

		if (!is_dir($this->_targetPath . 'Query')) {
			mkdir($this->_targetPath . 'Query', 0777);
		}

		if (!is_dir($this->_targetPath . 'Record')) {
			mkdir($this->_targetPath . 'Record', 0777);
		}
	}

	/**
	 * generateModel
	 *
	 * Generates all model files
	 *
	 * Saves the model files to the given target path.
	 * Internally it calls needed methods to generate base, query and
	 * active record classes of each UdaTable object in the metadata given in self::__construct.
	 *
	 * @return		bool							True in any case
	 * @throw		Exception		Throws an exception if one of the array values isn't a UdaTable
	 * @access		public
	 */
	public function generateModel() {
		$this->_generateDataSourceNameFile($this->_config);
		foreach ($this->_meta as $table) {
			if (!$table instanceof \Spaf\Library\Orm\Generator\Object\Table) {
				throw new Exception('Metadata isn\'t a array with \Spaf\Library\Orm\Generator\Object\Table objects!');
			}
			// dont generate files from n:m tables
			if ($table->isRelation()) {
				break;
			}

			$this->_generateBaseFiles($table);
			$this->_generateQueryFiles($table);
			$this->_generateRecordFiles($table);
			$this->_generateActiveRecordFiles($table);
		}
		return true;
	}

	public function setRuntimeNamespace($namespace) {
		$this->_runtimeNamespace = $namespace;
	}

	public function setModelNamespace($namespace) {
		$this->_modelNamespace = $namespace;
	}

	/**
	 * _generateBaseFiles
	 *
	 * Generates base model file
	 *
	 * This method generate the code of a base model file addicted to one UdaTable object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in self::__construct.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/base.php
	 * The base model files encapsulate some common functionality of query and record classes.
	 *
	 * @param		UdaTable					The UdaTable object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 */
	private function _generateBaseFiles(\Spaf\Library\Orm\Generator\Object\Table $table) {
		$string = '<?php' . "\n";
		$tplString = file_get_contents($this->_tplPath . 'base.php');
		$selfColumns = '';
		$selfPkColumns = '';
		// 'id', 'groups_id', 'name',  'pass', 'email'
		$columnArray = '';
		// 		const ID 			= 'users.id';
		$constants = "\t" . 'const ' . str_pad('TABLENAME', 30) . ' = \'`' . $table->getName() . '`\';' . "\n";
		// initialize counter
		$i = 1;
		foreach ($table->getColumns() as $column) {
			// get pk's
			if ($column->isPk()) {
				if ($i === 1) {
					$selfPkColumns .= 'self::' . strtoupper($column->getName());
				} else {
					$selfPkColumns .= ', self::' . strtoupper($column->getName());
				}
			}
			// get all columns
			if ($i === 1) {
				$selfColumns .= 'self::' . strtoupper($column->getName());
				$columnArray .= "'" . $column->getName() . "'";
			} else {
				$selfColumns .= ', self::' . strtoupper($column->getName());
				$columnArray .= ", '" . $column->getName() . "'";
			}
			$constants .=  '	const ' . str_pad(strtoupper($column->getName()), 30) . ' = \'`' . $table->getName() . '`.`' . $column->getName() . '`\'' . ";\n";
			// increment counter
			$i++;
		}

		$searches[] = "{model_namespace}";				$replaces[] = $this->_modelNamespace;
		$searches[] = "{runtime_namespace}";			$replaces[] = $this->_runtimeNamespace;
		$searches[] = "{uc_tablename}";					$replaces[] = ucfirst($table->getName());
		$searches[] = "{constants}";					$replaces[] = $constants;
		$searches[] = "{self_columns}";					$replaces[] = $selfColumns;
		$searches[] = "{self_pk_columns}";				$replaces[] = $selfPkColumns;
		$string .= str_replace($searches, $replaces, $tplString);
		$string .= "\n" . '?>';

		return file_put_contents($this->_targetPath . 'Base/' . ucfirst($table->getName()) . '.php', $string);
	}

	/**
	 * _generateQueryFiles
	 *
	 * Generates query model file
	 *
	 * This method generate the code of a query model file addicted to one UdaTable object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in self::__construct.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/query.php
	 * The query class is needed to read some record object from a database.
	 * So in fact it is responsible for any SELECT query.
	 *
	 * @param		UdaTable					The UdaTable object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 */
	private function _generateDataSourceNameFile(\Spaf\Library\Orm\Generator\Object\Config $config) {
		$string = "<?php\n";
		$tplString = file_get_contents($this->_tplPath . 'DataSourceName.php');
		$searches[] = "{model_namespace}";				$replaces[] = $this->_modelNamespace;
		$searches[] = "{runtime_namespace}";			$replaces[] = $this->_runtimeNamespace;
		$searches[] = "{sql_driver}";		$replaces[] = $this->_config->getSqlDriver();
		$searches[] = "{host}";				$replaces[] = $this->_config->getHost();
		$searches[] = "{port}";				$replaces[] = $this->_config->getPort();
		$searches[] = "{user}";				$replaces[] = $this->_config->getUser();
		$searches[] = "{pass}";				$replaces[] = $this->_config->getPass();
		$searches[] = "{name}";				$replaces[] = $this->_config->getName();
		$string .= str_replace($searches, $replaces, $tplString);
		$string .= "\n?>";

		return file_put_contents($this->_targetPath . 'Base/DataSourceName.php', $string);
	}

	/**
	 * _generateQueryFiles
	 *
	 * Generates query model file
	 *
	 * This method generate the code of a query model file addicted to one UdaTable object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in self::__construct.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/query.php
	 * The query class is needed to read some record object from a database.
	 * So in fact it is responsible for any SELECT query.
	 *
	 * @param		UdaTable					The UdaTable object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 */
	private function _generateQueryFiles(\Spaf\Library\Orm\Generator\Object\Table $table) {
		$string = "<?php\n";
		$tplString = file_get_contents($this->_tplPath . 'query.php');
		$searches[] = "{model_namespace}";				$replaces[] = $this->_modelNamespace;
		$searches[] = "{runtime_namespace}";			$replaces[] = $this->_runtimeNamespace;
		$searches[] = "{uc_tablename}";					$replaces[] = ucfirst($table->getName());
		$searches[] = "{tablename}";					$replaces[] = $table->getName();
		$string .= str_replace($searches, $replaces, $tplString);
		$string .= "\n?>";

		return file_put_contents($this->_targetPath . 'Query/' . ucfirst($table->getName()) . '.php', $string);
	}

	/**
	 * _generateActiveRecordFiles
	 *
	 * Generates active record model file
	 *
	 * This method generate the code of a active record model file addicted to one UdaTable object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in self::__construct.
	 * The source code to generate is so easy, it hasn't a code template.
	 * The active record class extends the record and is just for you to add
	 * custom functionality to your records. If this file will already exists,
	 * it will NOT be overwritten. So your custom code will not be destroyed.
	 *
	 * @param		UdaTable					The UdaTable object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 */
	private function _generateActiveRecordFiles(\Spaf\Library\Orm\Generator\Object\Table $table) {
		// If file does not exists already
		if (!is_file($this->_targetPath . ucfirst($table->getName()) . '.php')) {
			// ' . self::ID . ', ' . self::NAME . '
			$string = "<?php\n";
			$tplString = file_get_contents($this->_tplPath . 'class.php');
			$searches[] = "{model_namespace}";				$replaces[] = $this->_modelNamespace;
			$searches[] = "{runtime_namespace}";			$replaces[] = $this->_runtimeNamespace;
			$searches[] = "{uc_tablename}";					$replaces[] = ucfirst($table->getName());
			$searches[] = "{tablename}";					$replaces[] = $table->getName();
			$string .= str_replace($searches, $replaces, $tplString);
			$string .= "\n?>";
			return file_put_contents($this->_targetPath . ucfirst($table->getName()) . '.php', $string);
		}
		return false;
	}

	/**
	 * _generateRecordFiles
	 *
	 * Generates active record model file
	 *
	 * This method generate the code of a record model file addicted to one UdaTable object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in self::__construct.
	 * The source code to generate is from 4 files:
	 * 		./generatorTemplates/phpTemplates/php5/recordStart.php
	 * 		./generatorTemplates/phpTemplates/php5/recordGetterSetterMethods.php
	 * 		./generatorTemplates/phpTemplates/php5/recordForeignMethods.php
	 * 		./generatorTemplates/phpTemplates/php5/recordEnd.php
	 * This classes contains the main functionality of a record.
	 * It implements functionality for update, delete and in foreign methods, also for select statements.
	 *
	 * @param		UdaTable					The UdaTable object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 */
	private function _generateRecordFiles(\Spaf\Library\Orm\Generator\Object\Table $table) {
		$rec = new Record\Php6($this->_allMeta, $this->_targetPath);
		$rec->setModelNamespace($this->_modelNamespace);
		$rec->setRuntimeNamespace($this->_runtimeNamespace);
		$rec->generateRecordFile($table);
		return true;
	}

}

?>