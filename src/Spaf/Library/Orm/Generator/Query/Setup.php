<?php

namespace Cwa\Library\Orm\Generator\Query;

/**
 * UdaSetupQueryGenerator.php :: Generates the setup query
 *
 * This class is for generating setup queries for a specified dbms.
 *
 * @category	SetupQueryGenerator
 * @package		UwdDataAccess
 * @copyright	Copyright (c) 2008 - 2009 Claudio Walser, UWD GmbH
 * @author		Claudio Walser
 * @todo		Auf mehreren DBMS testen, momentan nur unter MySQL4 und MySQL5 getestet.
 */ 
class Setup {
	
	/**
	 * Stores the array of UdaTables
	 * @access		private
	 * @var			array
	 */
	private $_metadata = array();
	
	/**
	 * Stores the generated setup string
	 * @access		private
	 * @var			string
	 */
	private $_setupString = '';
	
	/**
	 * Stores the sql template object, addicted to sql version
	 * @access		private
	 * @var			UdaSqlTemplate
	 */
	private $_sqlTemplateObject = null;
	
	/**
	 * Stores the string of sql template driver
	 * @access		private
	 * @var			string
	 */
	private $_driver = null;
	
	/**
	 * constructor
	 *
	 * Instantiates the SetupQueryGenerator
	 *
	 * The constructor instante internal a UdaSqlTemplate object
	 * addicted to the given driver string. Also it stores the given 
	 * metadata, wich is a array of UdaTable objects, to perform the query generation.
	 * Currently, just mysql4 and mysql5 are supported as driver parameter.
	 *
	 * @param		array		meta		Metainformation in form of an array includes UdaTable objects
	 * @param		string		driver  	Optional: The sql driver as string, per default it is mysql4
	 * @access		public
	 */
	public function __construct($meta, $driver = 'mysql4') {
		$this->_driver = $driver;
		$this->_metadata = $meta['tables'];
		switch (strtolower($driver)) {
			case 'mysql5':
				$this->_sqlTemplateObject = new Template\Mysql5();
				break;
			
			case 'mysql4':
				$this->_sqlTemplateObject = new Template\Mysql4();
				break;
			
			default: 
				$this->_sqlTemplateObject = new Template\Mysql4();
				break;
		}
	}
	
	/**
	 * saveSetup
	 *
	 * Saves the setup query in a given file
	 *
	 * Saves the setup query in text file to the given path.
	 * Internally it calls the self::_generateTable method.
	 * Afer that, it writes the setup string into the given file.
	 *
	 * @param		string		sqlFile		Path of the sql file to save
	 * @return		bool					True if the sql file has ben written or false in case of any error
	 * @access		public
	 */
	public function saveSetup($sqlFile) {
		$this->_setupQuery = '';
		foreach ($this->_metadata as $table) {
			$this->_generateTable($table);
		}
		return file_put_contents($sqlFile . $this->_driver . '.sql', $this->_setupQuery);
	}
	
	/**
	 * _generateTable
	 *
	 * Generates the setup string of one table
	 *
	 * Generates the setup string of one given table.
	 * Internally it calls self::_generateColumn with any column it contains.
	 * The template string come from the instantiated UdaSqlTemplate object.
	 *
	 * @param		string		UdaTable	A UdaTable object to generate the setup string from
	 * @return		bool					Return true in any case
	 * @access		private
	 */
	private function _generateTable(\Cwa\Library\Orm\Generator\Object\Table $table) {
		$this->_setupQuery .= str_replace('{tablename}', $table->getName(), $this->_sqlTemplateObject->getCreateTable());
		
		// foreach all columns
		foreach($table->getColumns() as $column) {
			$this->_generateColumn($column);
		}
		
		
		// Get foreign keys
		$fks = $table->getFkColumns();
		if ($fks !== null) {
			foreach ($fks as $fk) {
				//CONSTRAINT `{constraint}` FOREIGN KEY ({foreignKey}) REFERENCES {foreignTable} ({foreignPrimaryKey});
				$search[0] = '{constraint}';
				$replace[0] = 'constr-' . $table->getName() . '-' . $fk->getName() . '-' . $fk->getForeignTable()->getName() . '-' . $fk->getForeignColumn()->getName();

				$search[1] = '{foreignKey}';
				$replace[1] = $fk->getName();

				$search[2] = '{foreignTable}';
				$replace[2] = $fk->getForeignTable()->getName();
				
				$search[3] = '{foreignPrimaryKey}';
				$replace[3] = $fk->getForeignColumn()->getName();
				
				$this->_setupQuery .= str_replace($search, $replace, $this->_sqlTemplateObject->getFkString());
			}
		}
		
		
		// Get primary key definition
		$pks = $table->getPkColumns();
		$primaryKeyString = '';
		if ($pks !== null) {
			$primaryKeyString = '';
			foreach ($pks as $pk) {
				$primaryKeyString .= (!empty($primaryKeyString) ? '`, `' : '') . $pk->getName();
			}
		}
		$this->_setupQuery .= str_replace('{pk_columnname}', $primaryKeyString, $this->_sqlTemplateObject->getPkString());
		
		$this->_setupQuery .= $this->_sqlTemplateObject->getCloseTable();
		
		return true;
	}
	
	/**
	 * _generateColumn
	 *
	 * Generates the setup string of one column
	 *
	 * Generates the setup string of one given column.
	 * The template string come from the instantiated UdaSqlTemplate object.
	 *
	 * @param		string		UdaColumn	A UdaColumn object to generate the setup string from
	 * @return		bool					Return true in any case
	 * @access		private
	 */
	private function _generateColumn(\Cwa\Library\Orm\Generator\Object\Column $col) {
		$default = $col->getDefault();
		$description = $col->getDescription();
		$search[] = '{columnname}';				$replace[] = $col->getName();
		$search[] = '{size}';					$replace[] = $col->getSize();
		$search[] = '{unsigned}';				$replace[] = $col->getUnsigned() === true ? $this->_sqlTemplateObject->getUnsigned() : '';
		$search[] = '{null}';					$replace[] = $col->getNull() === true ? $this->_sqlTemplateObject->getNull() : $this->_sqlTemplateObject->getNotNull();
		$search[] = '{default}';				$replace[] = !empty($default) ? $this->_sqlTemplateObject->getDefault() . ' \'' . $col->getDefault() . '\'' : '';
		$search[] = '{auto_increment}';			$replace[] = $col->getAutoIncrement() === true ? $this->_sqlTemplateObject->getAutoIncrement() : '';
		$search[] = '{description}';			$replace[] = !empty($description) ? $this->_sqlTemplateObject->getComment() . ' \'' . addslashes($col->getDescription()) . '\'' : '';
		
		$this->_setupQuery .= str_replace($search, $replace, $this->_sqlTemplateObject->getColumnTemplateString(strtolower($col->getType())));
		return true;
	}
	
}

?>