<?php
namespace Cwa\Library\Orm\Generator\Model\Record;
/**
 * UdaModelGeneratorPhp5Record.php :: Generates the php5 record model
 *
 * This class is the implemented generator for php 5 record model classes.
 *
 * @abstract
 * @category	ModelGenerator
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 */
class Php6 extends \Cwa\Library\Orm\Generator\Model\Php6 {

	/**
	 * generateRecordFile
	 *
	 * Generates a record file
	 *
	 * Saves the record model file to the given target path.
	 * Internally it calls needed methods to generate start, getter and setter and
	 * foreign method parts.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		public
	 */
	public function generateRecordFile(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$string = "<?php\n";

		$string .= $this->_getRecordStart($table);

		$string .= $this->_getSetterGetterMethods($table);
		$string .= $this->_getForeignMethods($table);

		$string .= $this->_getRecordEnd($table);

		$string .= "\n?>";

		$string = str_replace("\r\n", "\n", $string);

		//return file_put_contents($this->_targetPath . 'baseModel/' . ucfirst($table->getName()) . 'Record.php', $string);
		return file_put_contents($this->_targetPath . 'Record/' . ucfirst($table->getName()) . '.php', $string);
	}

	/**
	 * _getRecordStart
	 *
	 * Generates a the beginning of a record file
	 *
	 * This method generate the beginning code of a record model file addicted to one \Cwa\Library\Orm\Generator\Object\Table object
	 * wich is needed as only parameter to this function.
	 * It writes the file directly to the targetPath, given in parent::__construct.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordStart.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		bool						True if the file can be written, otherwise false
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getRecordStart(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$tplString = file_get_contents($this->_tplPath . 'recordStart.php');
		$searches[0] = "{uc_tablename}";				$replaces[0] = ucfirst($table->getName());
		$searches[1] = "{columns}";						$replaces[1] = $this->_getRecordColumnProperties($table);
		$searches[2] = "{nm_properties}";				$replaces[2] = $this->_getNmRelationProperties($table);
		$searches[3] = "{constructDataSwitch}";			$replaces[3] = $this->_getConstructDataSwitch($table);
		$searches[4] = "{model_namespace}";				$replaces[4] = $this->_modelNamespace;
		$searches[5] = "{runtime_namespace}";			$replaces[5] = $this->_runtimeNamespace;

		return str_replace($searches, $replaces, $tplString);
	}

	/**
	 * _getRecordColumnProperties
	 *
	 * Get all columns as class properties
	 *
	 * This method gets all database columns as class properties for the record file.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code with class properties of each column
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordStart
	 */
	private function _getRecordColumnProperties(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$columns = '';
		foreach ($table->getColumns() as $column) {
			$columns .= "\t" . '/**' . "\n";
			$columns .= "\t" . ' * Table column id' . "\n";
			$columns .= "\t" . ' *' . "\n";
			$columns .= "\t" . ' * @var		string' . "\n";
			$columns .= "\t" . ' * @access	private' . "\n";
			$columns .= "\t" . ' */' . "\n";
			$columns .= "\t" . 'private $_' . $column->getName() . ' = null;' . "\n\n";
		}
		return rtrim($columns) . "\n";
	}

	/**
	 * _getConstructDataSwitch
	 *
	 * Get the switch case code for constructor
	 *
	 * This method get the code for switch case instruction to seperating real data
	 * and just attributes. Attributes occur by selection data with a SELECT COUNT(*) AS attr query.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for switch case instruction for constructor
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordStart
	 */
	private function _getConstructDataSwitch(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$switch  = "\t\t\t\t" . 'switch($key) {' . "\n";

		foreach ($table->getColumns() as $column) {

			$switch .= "\t\t\t\t\t" . 'case \'' . $column->getName() . '\':' . "\n";
			$switch .= "\t\t\t\t\t\t" . '$this->set' . ucfirst($column->getName()) . '($value);' . "\n";
			$switch .= "\t\t\t\t\t\t" . 'break;' . "\n\n";

		}

		$switch .= "\t\t\t\t\t" . 'default:' . "\n";
		$switch .= "\t\t\t\t\t\t" . '$this->_attributes[$key] = $value;' . "\n";
		$switch .= "\t\t\t\t\t\t" . 'break;' . "\n\n";


		$switch .= "\t\t\t\t" . '}' . "";
		return $switch;
	}

	/**
	 * _getNmRelationProperties
	 *
	 * Get the properties for any child or parent table
	 *
	 * This method get the code of class properties of other tables
	 * wich has a n:m relation to this table.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for properties of foreign tables
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordStart
	 */
	private function _getNmRelationProperties(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$props = '';
		$inf = new \Cwa\Library\ThirdParty\Inflector();
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// child stuff
					$i = 1;
					$isFrom = false;
					$self = null;
					$foreign = null;
					foreach ($cols as $col) {
						if ($col->getForeignTable()->getName() === $table->getName() && $i <= $table->getPkCount()) {
							$isFrom = true;
							$self = $col->getForeignTable()->getName();
						}else if ($i > $table->getPkCount() && $self !== null) {
							$isFrom = true;
							$foreign = $col->getForeignTable()->getName();
						}

						$i++;
					}
					if ($self !== null && $foreign !== null && $isFrom === true) {
						$props .= "\t" . '/**' . "\n";
						$props .= "\t" . ' * All ' . $inf->pluralize($foreign) . ' added via ' . ucfirst($table->getName()) . '::add' . ucfirst($foreign) . '()' . "\n";
						$props .= "\t" . ' *' . "\n";
						$props .= "\t" . ' * @var		array' . "\n";
						$props .= "\t" . ' * @access	private' . "\n";
						$props .= "\t" . ' */' . "\n";
						$props .= "\t" . 'private $_' . $inf->pluralize($foreign) . ' = array();' . "\n\n";


						$props .= "\t" . '/**' . "\n";
						$props .= "\t" . ' * All ' . $inf->pluralize($foreign) . ' added via ' . ucfirst($table->getName()) . '::set' . ucfirst($inf->pluralize($foreign)) . '()' . "\n";
						$props .= "\t" . ' *' . "\n";
						$props .= "\t" . ' * @var		array' . "\n";
						$props .= "\t" . ' * @access	private' . "\n";
						$props .= "\t" . ' */' . "\n";
						$props .= "\t" . 'private $_set' . ucfirst($inf->pluralize($foreign)) . ' = array();' . "\n\n";


						$props .= "\t" . '/**' . "\n";
						$props .= "\t" . ' * All ' . $inf->pluralize($foreign) . ' removed via ' . ucfirst($table->getName()) . '::remove' . ucfirst($foreign) . '()' . "\n";
						$props .= "\t" . ' *' . "\n";
						$props .= "\t" . ' * @var		array' . "\n";
						$props .= "\t" . ' * @access	private' . "\n";
						$props .= "\t" . ' */' . "\n";
						$props .= "\t" . 'private $_remove' . ucfirst($inf->pluralize($foreign)) . ' = array();' . "\n\n\n";
					}
				}
			}
		}
		return rtrim($props) . "\n";
	}

	/**
	 * _getSetterGetterMethods
	 *
	 * Get the getter and setter methods of any column
	 *
	 * This method get the code for get/set methods of any
	 * column of this table.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordGetterSetterMethods.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for get/set methods for all columns
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getSetterGetterMethods(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$tplString = file_get_contents($this->_tplPath . 'recordSetterGetterMethods.php');
		$i = 1;
		$string = '';
		foreach ($table->GetColumns() as $column) {
			$searches[0] = "{columnname}";					$replaces[0] = $column->getName();
			$searches[1] = "{access}";						$replaces[1] = 'public';
			$searches[2] = "{uc_columnname}";				$replaces[2] = ucfirst($column->getName());
			$string .= str_replace($searches, $replaces, $tplString);

			$i++;
		}
		return $string;
	}

	/**
	 * _getForeignMethods
	 *
	 * Get the the code of all foreign methods
	 *
	 * Internally it calls methods for generating 1:1, 1:n and n:m methods.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for all foreign methods
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getForeignMethods(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$manyToMany = $this->_getManyToManyMethods($table);
		$oneToMany = $this->_getOneToManyMethods($table);
		$oneToOne = $this->_getOneToOneMethods($table);

		return $manyToMany . $oneToMany . $oneToOne;
	}

	/**
	 * _getManyToManyMethods
	 *
	 * Get the the code of n:m foreign methods
	 *
	 * This mehtod generate the code for getting records wich has a n:m relation to this record.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordForeignMethods.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for n:m foreign methods
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getForeignMethods
	 */
	private function _getManyToManyMethods(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$methods = '';
		// hole alle n:m Tabellen die von dieser Tabelle aus auf andere zeigen
		$inf = new \Cwa\Library\ThirdParty\Inflector();
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// child stuff
					$i = 1;
					$isFrom = false;
					$self = null;
					$selfCols = array();
					$foreign = null;
					$foreignCols = array();
					foreach ($cols as $col) {
						if ($col->getForeignTable()->getName() === $table->getName() && $i <= $table->getPkCount()) {
							$isFrom = true;
							$self = $col->getForeignTable()->getName();
							$selfCols[] = $col;
							$selfPkCols = $col->getForeignTable()->getPkColumns();
						}else if ($i > $table->getPkCount() && $self !== null) {
							$isFrom = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignCols[] = $col;
							$foreignPkCols = $col->getForeignTable()->getPkColumns();
						}

						$i++;
					}
					if ($self !== null && $foreign !== null && $isFrom === true) {
						$methods .= "\n\t" . '// get childs';
						$methods .= "\n\t" . 'public function get' . ucfirst($inf->pluralize($foreign)) . '($c = null) {' . "\n";

						$methods .= "\t\t" . 'if (!$c instanceof \\' . $this->_runtimeNamespace . '\\Query\\Criteria) {' . "\n";
						$methods .= "\t\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
						$methods .= "\t\t" . '}' . "\n";

						if ($self === $foreign) {
							$methods .= "\t\t" . '$c->selectTableAs(\'`' . $self{0} . '`\');' . "\n";

							$methods .= "\t\t" . 'if (!$c->issetCols()) {';
							$methods .= "\t\t\t" . '$c->setCols(\'';
							$i = 1;
							foreach ($table->getColumns() as $col) {
								$methods .= $i === 1 ? '' : ', ';
								$methods .= '`' . $self{0} . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";
							$methods .= "\t\t" . '}';
							//$c->setCols('`g`.`id`, `g`.`name`');


							$methods .= "\t\t" . '$c->leftJoin(\'`' . $t->getName() . '`\', \'';
							$i = 1;
							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = `' . $self{0} . '`.`' . $pkCol->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							//$methods .= "\t\t" . '$c->leftJoin(\'`' . $self . '`\', \'';`bla blagroup`.`id` = `grouptouser`.`fk_group_id`\');' . "\n";
							$methods .= "\t\t" . '$c->leftJoin(\'`' . $self . '`\', \'';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $self . '`.`' . $pkCol->getName() . '` = `' . $t->getName() . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							foreach ($selfPkCols as $col) {

								$methods .= "\t\t" . 'if (!$c->issetWhere()) {' . "\n";
								$methods .= "\t\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								$methods .= "\t\t" . '} else {' . "\n";
								$methods .= "\t\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								$methods .= "\t\t" . '}' . "\n";

							}

							$methods .= "" . '' . "\n";
							$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($foreign) . '::doSelect($c);' . "\n";







						} else {
							$methods .= "\t\t" . '$c->leftJoin(\'`' . $t->getName() . '`\', \'';
							$i = 1;
							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = `' . $foreign . '`.`' . $pkCol->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							$methods .= "\t\t" . '$c->leftJoin(\'`' . $self . '`\', \'';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $self . '`.`' . $pkCol->getName() . '` = `' . $t->getName() . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							foreach ($selfPkCols as $col) {
								$methods .= "\t\t" . 'if (!$c->issetWhere()) {' . "\n";
								$methods .= "\t\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								$methods .= "\t\t" . '} else {' . "\n";
								$methods .= "\t\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								$methods .= "\t\t" . '}' . "\n";
							}

							$methods .= "" . '' . "\n";
							$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($foreign) . '::doSelect($c);' . "\n";
						}
						$methods .= "\t}\n";

						$methods .= "\n\t" . '// add a child';
						$methods .= "\n\t" . 'public function add' . ucfirst($foreign) . '(' . ucfirst($foreign) . ' $obj) {' . "\n";
						$methods .= "\t\t" . 'if (count($this->_set' . ucfirst($inf->pluralize($foreign)) . ') > 0) {' . "\n";
						$methods .= "\t\t\t" . 'array_push($this->_set' . ucfirst($inf->pluralize($foreign)) . ', $obj);' . "\n";
						$methods .= "\t\t" . '} else {' . "\n";
						$methods .= "\t\t\t" . 'array_push($this->_' . $inf->pluralize($foreign) . ', $obj);' . "\n";
						$methods .= "\t\t" . '}' . "\n";
						$methods .= "\t}\n";

						$methods .= "\n\t" . '// remove a child';
						$methods .= "\n\t" . 'public function remove' . ucfirst($foreign) . '(' . ucfirst($foreign) . ' $obj) {' . "\n";
						$methods .= "\t\t" . 'if (count($this->_set' . ucfirst($inf->pluralize($foreign)) . ') === 0) {' . "\n";
						$methods .= "\t\t\t" . 'array_push($this->_remove' . ucfirst($inf->pluralize($foreign)) . ', $obj);' . "\n";
						$methods .= "\t\t" . '}' . "\n";
						$methods .= "\t}\n";

						$methods .= "\n\t" . '// set childs and delete all existent';
						$methods .= "\n\t" . 'public function set' . ucfirst($inf->pluralize($foreign)) . '($obj) {' . "\n";
						$methods .= "\t\t" . '$_obj = array();' . "\n";
						$methods .= "\t\t" . 'if (!is_array($obj) && $obj instanceof ' . ucfirst($foreign) . ') {' . "\n";
						$methods .= "\t\t\t" . '$_obj[0] = $obj;' . "\n";
						$methods .= "\t\t" . '} else if (!is_array($obj)) {' . "\n";
						$methods .= "\t\t\t" . 'throw new \\' . $this->_runtimeNamespace . '\\Exception(\'' . ucfirst($self) . '::set' . ucfirst($inf->pluralize($foreign)) . '() -- Just a ' . ucfirst($foreign) . ' object or a array of ' . ucfirst($foreign) . ' objects accepted as param. \' . gettype($obj) . \' given!\');' . "\n";
						$methods .= "\t\t" . '} else {' . "\n";
						$methods .= "\t\t\t" . '$_obj = $obj;' . "\n";
						$methods .= "\t\t" . '}' . "\n";
						$methods .= "\t\t" . '$obj = $_obj;' . "\n";
						$methods .= "\t\t" . '$this->_' . $foreign . ' = array();' . "\n";
						$methods .= "\t\t" . '$this->_remove' . ucfirst($inf->pluralize($foreign)) . ' = array();' . "\n";
						$methods .= "\t\t" . '$this->_set' . ucfirst($inf->pluralize($foreign)) . ' = $obj;' . "\n";
						$methods .= "\t}\n";

						foreach ($t->getColumns() as $col) {
							$_colName = $col->getName();
							if ($col->isFk()) {
								break;
							}
							$methods .= "\n\t" . '// get other attributes of the n:m relation table';
							$methods .= "\n\t" . 'public function get' . ucfirst($foreign) . ucfirst($col->getName()) . '(' . ucfirst($foreign) . ' $obj) {' . "\n";

							$methods .= "\t\t" . '$query = "SELECT `' . $_colName . '` FROM `' . $t->getName() . '` WHERE ';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = \'" . $this->get' . ucfirst($pkCol->getName()) . '() . "\'';
								$i++;
							}

							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = \'" . $obj->get' . ucfirst($pkCol->getName()) . '() . "\'';
							}
							$methods .= '";' . "\n";

							$methods .= "\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";
							$methods .= "\t\t" . '$value = self::$_dbh->getResultArray();' . "\n";
							$methods .= "\t\t" . 'return isset($value[0][\'' . $_colName . '\']) ? $value[0][\'' . $_colName . '\'] : null;' . "\n";
							$methods .= "\t}\n";


							$methods .= "\n\t" . '// set other attributes of the n:m relation table';
							$methods .= "\n\t" . 'public function set' . ucfirst($foreign) . ucfirst($_colName) . '($value, ' . ucfirst($foreign) . ' $obj) {' . "\n";

							$methods .= "\t\t" . '$query = "UPDATE `' . $t->getName() . '` SET `' . $_colName . '` = \'" . $value . "\' WHERE ';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = \'" . $this->get' . ucfirst($pkCol->getName()) . '() . "\'';
								$i++;
							}

							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = \'" . $obj->get' . ucfirst($pkCol->getName()) . '() . "\'';
							}
							$methods .= '";' . "\n";

							$methods .= "\t\t" . 'return  self::$_dbh->executeQuery($query);' . "\n";
							$methods .= "\t}\n";

						}

					}

					// parent stuff
					$isTo = false;
					$i = 1;
					$self = null;
					$selfCols = array();
					$foreign = null;
					$foreignCols = array();
					foreach ($cols as $col) {
						if ($i <= $table->getPkCount()) {
							$isTo = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignCols[] = $col;
							$foreignPkCols = $col->getForeignTable()->getPkColumns();
						} else if ($i > $table->getPkCount() && $col->getForeignTable()->getName() === $table->getName()) {
							$isTo = true;
							$self = $col->getForeignTable()->getName();
							$selfCols[] = $col;
							$selfPkCols = $col->getForeignTable()->getPkColumns();
						}
						$i++;
					}
					$parent = $foreign === $self ? 'Parent' : '';
					if ($self !== null && $foreign !== null && $isTo === true) {
						$methods .= "\n\t" . '// get parents';
						$methods .= "\n\t" . 'public function get' . $parent . ucfirst($inf->pluralize($foreign)) . '($c = null) {' . "\n";
						$methods .= "\t\t" . 'if (!$c instanceof \\' . $this->_runtimeNamespace . '\\Query\\Criteria) {' . "\n";
						$methods .= "\t\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
						$methods .= "\t\t" . '}' . "\n";
						if ($self === $foreign) {
							$methods .= "\t\t" . '// argh, set table alias' . "\n";
							//$methods .= "\t\t" . '$c = new DbCriteria();' . "\n";
							$methods .= "\t\t" . '$c->selectTableAs(\'`' . $self{0} . '`\');' . "\n";

							$methods .= "\t\t" . 'if (!$c->issetCols()) {';
							$methods .= "\t\t\t" . '$c->setCols(\'';
							$i = 1;
							foreach ($table->getColumns() as $col) {
								$methods .= $i === 1 ? '' : ', ';
								$methods .= '`' . $self{0} . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";
							$methods .= "\t\t" . '}';
							//$c->setCols('`g`.`id`, `g`.`name`');


							$methods .= "\t\t" . '$c->leftJoin(\'`' . $t->getName() . '`\', \'';
							$i = 1;
							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = `' . $self{0} . '`.`' . $pkCol->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							$methods .= "\t\t" . '$c->leftJoin(\'`' . $self . '`\', \'';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $self . '`.`' . $pkCol->getName() . '` = `' . $t->getName() . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							$i = 1;
							foreach ($selfPkCols as $col) {
								if ($i === 1) {
									$methods .= "\t\t" . 'if (!$c->issetWhere()) {' . "\n";
									$methods .= "\t\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
									$methods .= "\t\t" . '} else {' . "\n";
									$methods .= "\t\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
									$methods .= "\t\t" . '}' . "\n";
									//$methods .= "\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";


								} else {
									$methods .= "\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								}
								$i++;
							}

							$methods .= "" . '' . "\n";
							$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($foreign) . '::doSelect($c);' . "\n";
						} else {
							//$methods .= "\t\t" . '$c = new DbCriteria();' . "\n";
							$methods .= "\t\t" . '$c->leftJoin(\'`' . $t->getName() . '`\', \'';
							$i = 1;
							foreach ($foreignCols as $key => $col) {
								$pkCol = $foreignPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $t->getName() . '`.`' . $col->getName() . '` = `' . $foreign . '`.`' . $pkCol->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							$methods .= "\t\t" . '$c->leftJoin(\'`' . $self . '`\', \'';
							$i = 1;
							foreach ($selfCols as $key => $col) {
								$pkCol = $selfPkCols[$key];
								$methods .= $i === 1 ? '' : ' AND ';
								$methods .= '`' . $self . '`.`' . $pkCol->getName() . '` = `' . $t->getName() . '`.`' . $col->getName() . '`';
								$i++;
							}
							$methods .= '\');' . "\n";

							$i = 1;
							foreach ($selfPkCols as $col) {
								if ($i === 1) {
									$methods .= "\t\t" . 'if (!$c->issetWhere()) {' . "\n";
									$methods .= "\t\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
									$methods .= "\t\t" . '} else {' . "\n";
									$methods .= "\t\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
									$methods .= "\t\t" . '}' . "\n";
									//$methods .= "\t\t" . '$c->add(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								} else {
									$methods .= "\t\t" . '$c->addAnd(self::' . strtoupper($col->getName()) . ', $this->_' . $col->getName() . ');' . "\n";
								}
								$i++;
							}

							$methods .= "" . '' . "\n";
							$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($foreign) . '::doSelect($c);' . "\n";
						}
						$methods .= "\t}\n";
					}
				}

			}
		}

		return $methods;
	}

	/**
	 * _getOneToManyMethods
	 *
	 * Get the the code of 1:n foreign methods
	 *
	 * This mehtod generate the code for getting records wich has a 1:n relation to this record.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordForeignMethods.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for 1:n foreign methods
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getOneToManyMethods(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$cols = array();
		$methods = '';
		$i = 0;
		if ($table->getFkColumns() !== null) {
			// hole alle 1:n foreign Keys die von dieser Tabelle aus auf andere zeigen
			foreach  ($table->getFkColumns() as $column) {
				if ($column->getRelation() === '1:n') {
					if (!isset($cols[$column->getForeignTable()->getName()])) {
						$cols[$column->getForeignTable()->getName()]['cols'] = array();
						$cols[$column->getForeignTable()->getName()]['fkCols'] = array();
					}
					$cols[$column->getForeignTable()->getName()]['cols'][] = $column;
					$cols[$column->getForeignTable()->getName()]['fkCols'][] = $column->getForeignColumn();
				}
			}
			// methoden get und set bauen
			foreach  ($cols as $key => $value) {
				$methods .= "\n\t" . 'public function set' . ucfirst($key) . '(' . ucfirst($key) . ' $obj) {' . "\n";
				$methods .= "\t\t" . 'return ';
				// Zähler für Verknüpfung
				$i = 0;
				foreach ($value['cols'] as $k => $column) {
					$methods .= $i === 0 ? '' : ' && ';
					$fCol = $value['fkCols'][$k];
					$methods .= '$this->set' . ucfirst($column->getName()) . '($obj->get' . ucfirst($fCol->getName()) . '())';
					$i++;

				}
				// Umbruch nach dem Return und Methode abschliessen
				$methods .= ";\n";
				$methods .= "\t}\n";

				// get Methode bauen
				$methods .= "\n\t" . 'public function get' . ucfirst($key) . '($c = null) {' . "\n";
				$methods .= "\t\t" . 'if (!$c instanceof \\' . $this->_runtimeNamespace . '\\Query\\Criteria) {' . "\n";
				$methods .= "\t\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
				$methods .= "\t\t" . '}' . "\n";

				$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($key) . '::retrieveByPk(array(';
				// Zähler für Verknüpfung
				$i = 0;
				foreach ($value['cols'] as $key => $column) {
					$methods .= $i === 0 ? '' : ', ';
					//$this->getFk_dbDirectory_id()
					$methods .= '$this->get' . ucfirst($column->getName()) . '()';

					$i++;

				}
				// Umbruch nach dem Return und Methode abschliessen
				$methods .= '), $c);' . "\n";
				$methods .= "\t}\n";
			}
		}

		// hole alle 1:n foreign Keys die auf diese Tabelle zeigen
		// also «getChilds» Methoden
		$inf = new \Cwa\Library\ThirdParty\Inflector();
		foreach ($this->_meta as $t) {
			if ($t->isRelation()) {
				break;
			}

			$cols = $t->getFkColumns();
			if ($cols !== null) {
				$_cols = array();
				$i = 0;
				foreach ($cols as $column) {
					if ($column->getForeignTable()->getName() === $table->getName() && $column->getRelation() === '1:n') {
						if (!isset($cols[$column->getForeignTable()->getName()])) {
							$_cols[$table->getName()]['cols'] = array();
							$_cols[$table->getName()]['fkCols'] = array();
						}
						$_cols[$table->getName()]['cols'][] = $column;
						$_cols[$table->getName()]['fkCols'][] = $column->getForeignColumn();
					}
				}
				foreach  ($_cols as $key => $value) {
					$methods .= "\n\t" . 'public function get' . ucfirst($inf->pluralize($t->getName())) . '($c = null) {' . "\n";
					$methods .= "\t\t" . '// @todo			check existing \\' . $this->_runtimeNamespace . '\\Query\\Criteria object for specific queries' . "\n";
					$methods .= "\t\t" . 'if (!$c instanceof \\' . $this->_runtimeNamespace . '\\Query\\Criteria) {' . "\n";
					$methods .= "\t\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
					// Zähler für add() oder addAnd()
					$methods .= "\t\t" . '}' . "\n";
					$i = 0;
					foreach ($value['cols'] as $k => $column) {
						//$methods .= '$c->a' . ucfirst($column->getName()) . '($obj->get' . ucfirst($fCol->getName()) . '())';
						$fCol = $value['fkCols'][$k];
						if ($i === 0) {
								$methods .= "\t\t" . 'if ($c->issetWhere()) {' . "\n";
								$methods .= "\t\t\t" . '$c->addAnd(' . ucfirst($t->getName()) . '::' . strtoupper($column->getName()) . ', $this->get' . ucfirst($fCol->getName()) . '());' . "\n";
								$methods .= "\t\t" . '} else {' . "\n";
								$methods .= "\t\t\t" . '$c->add(' . ucfirst($t->getName()) . '::' . strtoupper($column->getName()) . ', $this->get' . ucfirst($fCol->getName()) . '());' . "\n";
								$methods .= "\t\t" . '}' . "\n";
						} else {
								$methods .= "\t\t" . '$c->addAnd(' . ucfirst($t->getName()) . '::' . strtoupper($column->getName()) . ', $this->get' . ucfirst($fCol->getName()) . '());' . "\n";
						}
						$i++;
					}
					$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($t->getName()) . '::doSelect($c);' . "\n";
					// Methode abschliessen
					$methods .= "\t}\n";
				}
			}
		}
		return $methods;
	}

	/**
	 * _getOneToOneMethods
	 *
	 * Get the the code of 1:1 foreign methods
	 *
	 * This mehtod generate the code for getting records wich has a 1:1 relation to this record.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordForeignMethods.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for 1:1 foreign methods
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getOneToOneMethods(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$cols = array();
		$methods = '';
		$i = 0;
		// hole alle 1:1 foreign Keys die von dieser Tabelle aus auf andere zeigen
		if ($table->getFkColumns() !== null) {
			foreach  ($table->getFkColumns() as $column) {
				if ($column->getRelation() === '1:1') {
					if (!isset($cols[$column->getForeignTable()->getName()])) {
						$cols[$column->getForeignTable()->getName()]['cols'] = array();
						$cols[$column->getForeignTable()->getName()]['fkCols'] = array();
					}
					$cols[$column->getForeignTable()->getName()]['cols'][] = $column;
					$cols[$column->getForeignTable()->getName()]['fkCols'][] = $column->getForeignColumn();
				}
			}

			// methoden get und set bauen
			foreach  ($cols as $key => $value) {
				$methods .= "\n\t" . 'public function set' . ucfirst($key) . '(' . ucfirst($key) . ' $obj) {' . "\n";


				$methods .= "\t\t" . 'if ($obj->get' . ucfirst($table->getName()) . '() !== null && $obj->get' . ucfirst($table->getName()) . '() !== $this) {' . "\n";
				$methods .= "\t\t\t" . 'throw new \\' . $this->_runtimeNamespace . '\\Exception(\'' . ucfirst($table->getName()) . ':: Param ' . $key . ' has already a relation. Since it\\\'s a 1:1 relation, this operation is not allowed!\');' . "\n";
				$methods .= "\t\t" . '}' . "\n";

				$methods .= "\t\t" . 'return ';
				// Zähler für Verknüpfung
				$i = 0;
				foreach ($value['cols'] as $k => $column) {
					$methods .= $i === 0 ? '' : ' && ';
					$fCol = $value['fkCols'][$k];
					$methods .= '$this->set' . ucfirst($column->getName()) . '($obj->get' . ucfirst($fCol->getName()) . '())';
					$i++;

				}
				// Umbruch nach dem Return und Methode abschliessen
				$methods .= ";\n";
				$methods .= "\t}\n";

				// get Methode bauen
				$methods .= "\n\t" . 'public function get' . ucfirst($key) . '($c = null) {' . "\n";
				$methods .= "\t\t" . 'if (!$c instanceof \\' . $this->_runtimeNamespace . '\\Query\\Criteria) {' . "\n";
				$methods .= "\t\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
				$methods .= "\t\t" . '}' . "\n";

				$methods .= "\t\t" . 'return \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($key) . '::retrieveByPk(array(';
				// Zähler für Verknüpfung
				$i = 0;
				foreach ($value['cols'] as $key => $column) {
					$methods .= $i === 0 ? '' : ', ';
					//$this->getFk_dbDirectory_id()
					$methods .= '$this->get' . ucfirst($column->getName()) . '()';

					$i++;

				}
				// Umbruch nach dem Return und Methode abschliessen
				$methods .= '), $c);' . "\n";
				$methods .= "\t}\n";
			}
		}


		// hole alle 1:1 foreign Keys die auf diese Tabelle zeigen
		// also «getChilds» Methoden
		foreach ($this->_meta as $key => $t) {
			if ($t->isRelation()) {
				break;
			}

			$cols = $t->getFkColumns();
			if ($cols !== null) {
				$_cols = array();
				$i = 0;
				foreach ($cols as $column) {
					if ($column->getForeignTable()->getName() === $table->getName() && $column->getRelation() === '1:1') {
						if (!isset($cols[$column->getForeignTable()->getName()])) {
							$_cols[$table->getName()]['cols'] = array();
							$_cols[$table->getName()]['fkCols'] = array();
						}
						$_cols[$table->getName()]['cols'][] = $column;
						$_cols[$table->getName()]['fkCols'][] = $column->getForeignColumn();
					}
				}

				$parent = $t->getName() === $table->getName() ? 'Parent' : '';

				foreach  ($_cols as $key => $value) {
					$methods .= "\n\t" . 'public function get' . $parent . ucfirst($t->getName()) . '($c = null) {' . "\n";
					$methods .= "\t\t" . '// @todo			check existing \\' . $this->_runtimeNamespace . '\\Query\\Criteria object for specific queries' . "\n";
					$methods .= "\t\t" . '$c = new \\' . $this->_runtimeNamespace . '\\Query\\Criteria();' . "\n";
					// Zähler für add() oder addAnd()
					$i = 0;
					foreach ($value['cols'] as $k => $column) {
						//$methods .= '$c->a' . ucfirst($column->getName()) . '($obj->get' . ucfirst($fCol->getName()) . '())';
						$fCol = $value['fkCols'][$k];
						if ($i === 0) {
								$methods .= "\t\t" . '$c->add(' . ucfirst($t->getName()) . '::' . strtoupper($column->getName()) . ', $this->get' . ucfirst($fCol->getName()) . '());' . "\n";
						} else {
								$methods .= "\t\t" . '$c->addAnd(' . ucfirst($t->getName()) . '::' . strtoupper($column->getName()) . ', $this->get' . ucfirst($fCol->getName()) . '());' . "\n";
						}
						$i++;
					}
					$methods .= "\t\t" . '$objs = \\' . $this->_modelNamespace . '\\Query\\' . ucfirst($t->getName()) . '::doSelect($c);' . "\n";
					$methods .= "\t\t" . 'return $objs !== null ? $objs[0] : null;' . "\n";
					// Methode abschliessen
					$methods .= "\t}\n";
				}
			}
		}

		return $methods;
	}

	/**
	 * _getRecordEnd
	 *
	 * Get the end code of a record
	 *
	 * This mehtod generate the end code for a record.
	 * This contains the doSave, doDelete, _doInsert, _doUpdate, _saveChilds and _deleteChilds methods.
	 * The source code to generate is from ./generatorTemplates/phpTemplates/php5/recordEnd.php
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the model from
	 * @return		string						The php code for the file end of a record
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::generateRecordFile
	 */
	private function _getRecordEnd(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$tplString = file_get_contents($this->_tplPath . 'recordEnd.php');
		$searches[0] = "{tablename}";						$replaces[0] = $table->getName();
		$searches[1] = "{pk_loop}";							$replaces[1] = $this->_getPkLoop($table);

		$searches[2] = "{columns}";							$replaces[2] = $this->_getColumnString($table);
		$searches[3] = "{values}";							$replaces[3] = $this->_getValueString($table);

		$searches[4] = "{where_pk}";						$replaces[4] = $this->_getPkLoop($table);
		$searches[5] = "{update_values}";					$replaces[5] = $this->_getUpdateValueString($table);


		$searches[6] = "{save_childs}";						$replaces[6] = $this->_getSaveChilds($table);
		$searches[7] = "{overwrite_childs}";				$replaces[7] = $this->_getOverwriteChilds($table);

		$searches[8] = "{delete_childs}";					$replaces[8] = $this->_getDeleteChilds($table);
		$searches[9] = "{delete_parents}";					$replaces[9] = $this->_getDeleteParents($table);

		$searches[10] = "{model_namespace}";				$replaces[10] = $this->_modelNamespace;
		$searches[11] = "{runtime_namespace}";				$replaces[11] = $this->_runtimeNamespace;

		return str_replace($searches, $replaces, $tplString);
	}

	/**
	 * _getColumnString
	 *
	 * Get a comma separated string of all columns
	 *
	 * This mehtod generate a comma separated string of all columns for SELECT queries.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the column string from
	 * @return		string						The php code for the column string
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 * @todo		looking for non auto increment systems
	 */
	private function _getColumnString(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$colStr = '';
		foreach ($table->getColumns() as $col) {
			if ($col->isPk() && $col->getAutoIncrement()) {
				// looking for non auto increment systems
				/*$colStr .= empty($colStr) ? '' : ', ';
				$colStr .= '`AC`';*/
			} else {
				$colStr .= empty($colStr) ? '' : ', ';
				$colStr .= '`' . $col->getName() . '`';
			}
		}
		return $colStr;
	}

	/**
	 * _getValueString
	 *
	 * Get a comma separated string of all column values
	 *
	 * This mehtod generate a comma separated string of all columns values for INSERT queries.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the value string from
	 * @return		string						The php code for the column value string
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 * @todo		looking for non auto increment systems
	 */
	private function _getValueString(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$valStr = '';
		foreach ($table->getColumns() as $col) {
			if ($col->isPk() && $col->getAutoIncrement()) {
				// looking for non auto increment systems
				/*$valStr .= empty($valStr) ? '' : ', ';
				$valStr .= "\\''" . ' . self::$_dbh->escapeValue($this->AC' . ") . '\\'";*/
			} else {
				$valStr .= empty($valStr) ? '' : ', ';
				$valStr .= "\\''" . ' . self::$_dbh->escapeValue($this->_' . $col->getName() . ") . '\\'";
			}
		}
		return $valStr;
	}

	/**
	 * _getUpdateValueString
	 *
	 * Get a string with all columns for UPDATE
	 *
	 * This mehtod generate a string of all columns and values for UPDATE queries.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the updateValue string from
	 * @return		string						The php code for the columns and values UPDATE string
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getUpdateValueString(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$valStr = '';
		foreach ($table->getColumns() as $col) {
			$valStr .= empty($valStr) ? ' ' : ',' . "\n\t\t\t\t\t";
			$valStr .= "`" . $col->getName() . "` = \\''" . ' . self::$_dbh->escapeValue($this->_' . $col->getName() . ") . '\\'";
		}
		return $valStr;
	}

	/**
	 * _getDeleteChilds
	 *
	 * Find childs wich will be deleted
	 *
	 * This mehtod generate a string for the _doDelete method.
	 * All neccessary childs will be deleted to. This is addicted to
	 * your relation definitions. Set up your relation with event onDelete
	 * and action delete will perform this.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the deleteChild string from
	 * @return		string						The php code for the delete child method
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getDeleteChilds(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$delStr = '';
		$inf = new \Cwa\Library\ThirdParty\Inflector();

		// n:m Stuff
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// child stuff
					$i = 1;
					$isFrom = false;
					$self = null;
					$foreign = null;
					$selfCol = array();
					$foreignCol = array();
					foreach ($cols as $col) {
						if ($col->getForeignTable()->getName() === $table->getName() && $i <= $table->getPkCount()) {
							$isFrom = true;
							$self = $col->getForeignTable()->getName();
							$pkCols = $col->getForeignTable()->getPkColumns();
							$selfCol[] = $col;
						}else if ($i > $table->getPkCount() && $self !== null) {
							$isFrom = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignCol[] = $col;
						}

						$i++;
					}
					if ($self !== null && $foreign !== null && $isFrom === true) {
						$delStr .= "\t\t" . '// delete child-' . $foreign . '-dependencies from this object' . "\n";
						$delStr .= "\t\t" . 'try {' . "\n";
						$delStr .= "\t\t\t" . '$query = \'DELETE FROM `' . $t->getName() . '`' . "\n";

						$delStr .= "\t\t\t\t\t\t" . "WHERE ";
						$i = 1;
						foreach ($selfCol as $key => $col) {
							$fcol = $pkCols[$key];
							$delStr .= $i === 1 ? '' : ' AND ';
							$delStr .= '`' . $col->getName() . "` = \\'' . " . '$this->_' . $fcol->getName() . " . '\\'";
							$i++;
						}
						$delStr .= "';\n";
						$delStr .= "\t\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";
						$delStr .= "\t\t" . '} catch (\\' . $this->_runtimeNamespace . '\\Driver\\Exception $e) {' . "\n";
						$delStr .= "\t\t\t" . '// rollback transaction and throw \\' . $this->_runtimeNamespace . '\\Driver\\Exception' . "\n";
						$delStr .= "\t\t\t" . 'self::$_dbh->rollback();' . "\n";
						$delStr .= "\t\t\t" . 'throw new \\' . $this->_runtimeNamespace . '\\Driver\\Exception($e->getMessage());' . "\n";
						$delStr .= "\t\t" . '}' . "\n";

					}
				}
			}
		}

		$inf = new \Cwa\Library\ThirdParty\Inflector();
		foreach ($this->_meta as $t) {
			if ($t->isRelation()) {
				break;
			}
			$cols = $t->getFkColumns();
			if ($cols !== null) {
				$_cols = array();
				$i = 0;
				foreach ($cols as $column) {
					if ($column->getForeignTable()->getName() === $table->getName() && $column->getEvent() === 'onDelete' && $column->getAction() === 'delete' && ($column->getRelation() === '1:n' || $column->getRelation() === '1:1')) {
						if ($column->getRelation() === '1:n') {
							$delStr .= "\t\t" . '$childs = $this->get' .ucfirst($inf->pluralize($t->getName())) . "();\n";
							$delStr .= "\t\t" . 'if ($childs !== null) {' . "\n";
							$delStr .= "\t\t\t" . 'foreach($childs as $child) {' . "\n";
							$delStr .= "\t\t\t\t" . '$child->doDelete();' . "\n";
							$delStr .= "\t\t\t" . '}' . "\n";
							$delStr .= "\t\t" . '}' . "\n";
						} else {
							//$delStr .= "\t\t" . '$child = $this->get' .ucfirst($inf->pluralize($t->getName())) . "();\n";
							$delStr .= "\t\t" . '$child = $this->get' .ucfirst($t->getName()) . "();\n";
							$delStr .= "\t\t" . 'if ($child !== null) {' . "\n";
							$delStr .= "\t\t\t" . '$child->doDelete();' . "\n";
							$delStr .= "\t\t" . '}' . "\n";
						}
					} else  if ($column->getForeignTable()->getName() === $table->getName() && $column->getEvent() === 'onDelete' && $column->getAction() === 'setNull' && ($column->getRelation() === '1:n' || $column->getRelation() === '1:1')) {
						if ($column->getRelation() === '1:n') {
							$delStr .= "\t\t" . '$childs = $this->get' .ucfirst($inf->pluralize($t->getName())) . "();\n";
							$delStr .= "\t\t" . 'if ($childs !== null) {' . "\n";
							$delStr .= "\t\t\t" . 'foreach($childs as $child) {' . "\n";
							$delStr .= "\t\t\t\t" . '$child->setFk_' . $table->getName() . '_' . $table->getPkString() . '(0);' . "\n";
							$delStr .= "\t\t\t\t" . '$child->doSave();' . "\n";
							$delStr .= "\t\t\t" . '}' . "\n";
							$delStr .= "\t\t" . '}' . "\n";
						} else {
							//$delStr .= "\t\t" . '$child = $this->get' .ucfirst($inf->pluralize($t->getName())) . "();\n";
							$delStr .= "\t\t" . '$child = $this->get' .ucfirst($t->getName()) . "();\n";
							$delStr .= "\t\t" . 'if ($child !== null) {' . "\n";
							$delStr .= "\t\t\t" . '$child->setFk_' . $table->getName() . '_' . $table->getPkString() . '(0);' . "\n";
							$delStr .= "\t\t\t" . '$child->doSave();' . "\n";
							$delStr .= "\t\t" . '}' . "\n";
						}
					}
				}
			}
		}

		return rtrim($delStr) . "\n";
	}

	/**
	 * _getDeleteParents
	 *
	 * Find parents wich will be deleted
	 *
	 * This mehtod generate a string for the _doDelete method.
	 * All neccessary parents will be deleted to. This is addicted to
	 * your relation definitions. Just n:m relation records will be deleted too.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the deleteParent string from
	 * @return		string						The php code for the delete parent method
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getDeleteParents(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$delStr = '';
		$inf = new \Cwa\Library\ThirdParty\Inflector();

		// n:m Stuff
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// parent stuff
					$isTo = false;
					$i = 1;
					$self = null;
					$foreign = null;
					$selfCol = array();
					$foreignCol = array();
					foreach ($cols as $col) {
						if ($i <= $table->getPkCount()) {
							$isTo = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignCol[] = $col;
						} else if ($i > $table->getPkCount() && $col->getForeignTable()->getName() === $table->getName()) {
							$isTo = true;
							$self = $col->getForeignTable()->getName();
							$pkCols = $col->getForeignTable()->getPkColumns();
							$selfCol[] = $col;
						}
						$i++;
					}
					$parent = $foreign === $self ? 'Parent' : '';

					if ($self !== null && $foreign !== null && $isTo === true) {
						$delStr .= "\t\t" . '// delete parent-' . $foreign . '-dependencies from this object' . "\n";
						$delStr .= "\t\t" . 'try {' . "\n";
						$delStr .= "\t\t\t" . '$query = \'DELETE FROM `' . $t->getName() . '`' . "\n";

						$delStr .= "\t\t\t\t\t\t" . "WHERE ";
						$i = 1;
						foreach ($selfCol as $key => $col) {
							$fcol = $pkCols[$key];
							$delStr .= $i === 1 ? '' : ' AND ';
							$delStr .= '`' . $col->getName() . "` = \\'' . " . '$this->_' . $fcol->getName() . " . '\\'";
							$i++;
						}
						$delStr .= "';\n";

						$delStr .= "\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";
						$delStr .= "\t\t" . '} catch (\\' . $this->_runtimeNamespace . '\\Driver\\Exception $e) {' . "\n";
						$delStr .= "\t\t\t" . '// rollback transaction and throw \\' . $this->_runtimeNamespace . '\\Driver\\Exception' . "\n";
						$delStr .= "\t\t\t" . 'self::$_dbh->rollback();' . "\n";
						$delStr .= "\t\t\t" . '\\' . $this->_runtimeNamespace . '\\Driver\\Exception($e->getMessage());' . "\n";
						$delStr .= "\t\t" . '}' . "\n";

					}
				}
			}
		}
		return rtrim($delStr) . "\n";
	}

	/**
	 * _getSaveChilds
	 *
	 * Find the code of saveChilds method
	 *
	 * This mehtod generate a string for the _saveChilds method.
	 * This is important for save childs wich are added over record::addChild.
	 * By calling doSave on a object, its new child relations will be saved too.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the saveChilds string from
	 * @return		string						The php code for the saveChilds method
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getSaveChilds(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$saveStr = '';
		$inf = new \Cwa\Library\ThirdParty\Inflector();

		// n:m Stuff
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// child stuff
					$i = 1;
					$isFrom = false;
					$self = null;
					$foreign = null;
					$selfCol = array();
					$foreignCol = array();
					foreach ($cols as $col) {
						if ($col->getForeignTable()->getName() === $table->getName() && $i <= $table->getPkCount()) {
							$isFrom = true;
							$self = $col->getForeignTable()->getName();
							$pkCols = $col->getForeignTable()->getPkColumns();
							$selfCol[] = $col;
						}else if ($i > $table->getPkCount() && $self !== null) {
							$isFrom = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignPkCols = $col->getForeignTable()->getPkColumns();
							$foreignCol[] = $col;
						}

						$i++;
					}
					if ($self !== null && $foreign !== null && $isFrom === true) {
						// add objects
						$saveStr .= "\t\t" . '// ' . $foreign . "\n";
						$saveStr .= "\t\t" . 'if (count($this->_set' . ucfirst($inf->pluralize($foreign)) . ') > 0) {' . "\n";
						$saveStr .= "\t\t\t" . 'return false;' . "\n";
						$saveStr .= "\t\t" . '}' . "\n";
						$saveStr .= "\t\t" . 'if (count($this->_' . $inf->pluralize($foreign) . ') > 0) {' . "\n";
						$saveStr .= "\t\t\t" . 'foreach ($this->_' . $inf->pluralize($foreign) . ' as $obj) {' . "\n";

						$saveStr .= "\t\t\t\t" . '$query = \'INSERT INTO `' . $t->getName() . '` (';
						$i = 1;
						foreach ($selfCol as $col) {
							$saveStr .= $i > 1 ? ', ' : '';
							$saveStr .= '`' . $col->getName() . '`';
							$i++;
						}

						foreach ($foreignCol as $col) {
							$saveStr .= ', ';
							$saveStr .= '`' . $col->getName() . '`';
						}

						$saveStr .= ') VALUES (';
						$i = 1;
						foreach ($selfCol as $key => $col) {
							$saveStr .= $i > 1 ? ', ' : '';
							$saveStr .= "\\'' . " . '$this->get' . ucfirst($pkCols[$key]->getName()) . '() . ' . "'\\'";
							$i++;
						}

						foreach ($foreignCol as $key => $col) {
							$saveStr .= ', ';
							$saveStr .= "\\'' . " . '$obj->get' . ucfirst($foreignPkCols[$key]->getName()) . '() . ' . "'\\'";
						}

						$saveStr .= ')\';' . "\n";

						$saveStr .= "\t\t\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";

						$saveStr .= "\t\t\t" . '}' . "\n";
						$saveStr .= "\t\t\t" . '$this->_' . $inf->pluralize($foreign) . ' = array();' . "\n";
						$saveStr .= "\t\t}\n";

						// remove objects
						$saveStr .= "\t\t" . '// ' . $foreign . "\n";
						$saveStr .= "\t\t" . 'if (count($this->_remove' . ucfirst($inf->pluralize($foreign)) . ') > 0) {' . "\n";
						$saveStr .= "\t\t\t" . 'foreach ($this->_remove' . ucfirst($inf->pluralize($foreign)) . ' as $obj) {' . "\n";

						$saveStr .= "\t\t\t\t" . '$query = \'DELETE FROM `' . $t->getName() . '`' . "\n";
						$saveStr .= "\t\t\t\t\t\t\t" . ' WHERE ';

						$i = 1;
						foreach ($selfCol as $key => $col) {
							$saveStr .= $i === 1 ? '' : ' AND ';
							$saveStr .= '`' . $col->getName() . '` = ' . "\\'' . " . '$this->get' . ucfirst($pkCols[$key]->getName()) . '() . ' . "'\\'";
							$i++;
						}

						foreach ($foreignCol as $key => $col) {
							$saveStr .= ' AND';
							$saveStr .= '`' . $col->getName() . '` = ' . "\\'' . " . '$obj->get' . ucfirst($pkCols[$key]->getName()) . '() . ' . "'\\'";
						}
						$saveStr .= '\';' . "\n";

						$saveStr .= "\t\t\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";

						$saveStr .= "\t\t\t" . '}' . "\n";
						$saveStr .= "\t\t\t" . '$this->_remove' . ucfirst($inf->pluralize($foreign)) . ' = array();' . "\n";
						$saveStr .= "\t\t}\n";
					}
				}
			}
		}
		return rtrim($saveStr) . "\n";
	}

	/**
	 * _getOverwriteChilds
	 *
	 * Find the code of overwriteChilds method
	 *
	 * This mehtod generate a string for the _overwriteChilds method.
	 * This is important for save childs wich are added over record::addChild.
	 * By calling doSave on a object, its changed child relations will be managed too.
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the overwriteChilds string from
	 * @return		string						The php code for the overwriteChilds method
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getOverwriteChilds(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$saveStr = '';
		$inf = new \Cwa\Library\ThirdParty\Inflector();

		// n:m Stuff
		foreach  ($this->_meta as $t) {
			// Wenn es sich bei der Tabelle um eine n:m Beziehungstabelle handelt
			if ($t->isRelation()) {
				$cols = $t->getFkColumns();
				if ($cols !== null) {
					// child stuff
					$i = 1;
					$isFrom = false;
					$self = null;
					$foreign = null;
					$selfCol = array();
					$foreignCol = array();
					foreach ($cols as $col) {
						if ($col->getForeignTable()->getName() === $table->getName() && $i <= $table->getPkCount()) {
							$isFrom = true;
							$self = $col->getForeignTable()->getName();
							$pkCols = $col->getForeignTable()->getPkColumns();
							$selfCol[] = $col;
						}else if ($i > $table->getPkCount() && $self !== null) {
							$isFrom = true;
							$foreign = $col->getForeignTable()->getName();
							$foreignPkCols = $col->getForeignTable()->getPkColumns();
							$foreignCol[] = $col;
						}

						$i++;
					}
					if ($self !== null && $foreign !== null && $isFrom === true) {
						$saveStr .= "\t\t" . '// ' . $foreign . "\n";
						$saveStr .= "\t\t" . 'if (count($this->_set' . ucfirst($inf->pluralize($foreign)) . ') > 0) {' . "\n";
						$saveStr .= "\t\t\t" . '$query = \'DELETE FROM `' . $t->getName() . '`' . "\n";

						$saveStr .= "\t\t\t\t\t\t" . "WHERE ";
						$i = 1;
						foreach ($selfCol as $key => $col) {
							$fcol = $pkCols[$key];
							$saveStr .= $i === 1 ? '' : ' AND ';
							$saveStr .= '`' . $col->getName() . "` = \\'' . " . '$this->_' . $fcol->getName() . " . '\\'";
							$i++;
						}
						$saveStr .= "';\n";
						$saveStr .= "\t\t\t" . 'self::$_dbh->executeQuery($query);' . "\n\n";

						$saveStr .= "\t\t\t" . 'foreach ($this->_set' . ucfirst($inf->pluralize($foreign)) . ' as $obj) {' . "\n";

						$saveStr .= "\t\t\t\t" . '$query = \'INSERT INTO `' . $t->getName() . '` (';
						$i = 1;
						foreach ($selfCol as $col) {
							$saveStr .= $i > 1 ? ', ' : '';
							$saveStr .= '`' . $col->getName() . '`';
						}

						foreach ($foreignCol as $col) {
							$saveStr .= ', ';
							$saveStr .= '`' . $col->getName() . '`';
						}

						$saveStr .= ') VALUES (';
						$i = 1;
						foreach ($selfCol as $key => $col) {
							$saveStr .= $i > 1 ? ', ' : '';
							$saveStr .= "\\'' . " . '$this->get' . ucfirst($pkCols[$key]->getName()) . '() . ' . "'\\'";
							$i++;
						}

						foreach ($foreignCol as $key => $col) {
							$saveStr .= ', ';
							$saveStr .= "\\'' . " . '$obj->get' . ucfirst($foreignPkCols[$key]->getName()) . '() . ' . "'\\'";
						}

						$saveStr .= ')\';' . "\n";

						$saveStr .= "\t\t\t\t" . 'self::$_dbh->executeQuery($query);' . "\n";

						$saveStr .= "\t\t\t" . '}' . "\n";
						$saveStr .= "\t\t\t" . '$this->_set' . ucfirst($inf->pluralize($foreign)) . ' = array();' . "\n";
						$saveStr .= "\t\t}\n";

					}
				}
			}
		}
		return rtrim($saveStr) . "\n";
	}

	/**
	 * _getPkLoop
	 *
	 * Get the primary key string for update statements
	 *
	 * This mehtod generate a string with the primary key to use it in WHERE id=3 queries.
	 * This loop is important for tables with more than one columns defined as primary key
	 *
	 * @param		\Cwa\Library\Orm\Generator\Object\Table					The \Cwa\Library\Orm\Generator\Object\Table object wich you want generate the primary key string from
	 * @return		string						The php code for the primary key string
	 * @access		private
	 * @see			UdaModelGeneratorPhp5Record::_getRecordEnd
	 */
	private function _getPkLoop(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$pk = '';
		foreach ($table->getPkColumns() as $col) {
			if ($pk === '') {
				$pk .= "`" . $col->getName() . "` = \\'' . " . '$this->_' . $col->getName() . " . '\\'";
			} else {
				$pk .= ' AND ' . "`" . $col->getName() . "` = \\'' . " . '$this->_' . $col->getName() . " . '\\'";
			}
		}
		return $pk;
	}
}

?>