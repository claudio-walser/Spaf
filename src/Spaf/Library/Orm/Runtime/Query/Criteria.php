<?php
/**
 * $Id$
 * Database criterion class
 *
 * @created 	Fri Jul 30 05:25:27 CET 2010
 * @author 		Claudio Walser
 * @reviewer 	TODO
 * @package		\Spaf\Library\Orm\Runtime
 * @namespace	\Spaf\Library\Orm\Runtime\Query
 */
namespace Spaf\Library\Orm\Runtime\Query;


/**
 * Spaf\Library\Orm\Runtime\Query\FluentInterface
 *
 * The criterion class provides you and oo interface 
 * to define queries.
 *
 * @author 		Claudio Walser
 */
class Criteria {

	/**
	 * Columns to read in a select query.
	 *
	 * @var		string
     */
	private $_cols		= "";

	/**
	 * Tyxpe of the query.
	 * Possible values: SELECT>
	 *
	 * @var		string
     */
	private $_type 		= "SELECT";

	/**
	 * The table alias name to select from
	 *
	 * @var		string
     */
	private $_tableAlias = null;

	/**
	 * Array for left join conditions
	 *
	 * @var		array
     */
	private $_leftJoin 	= array();

	/**
	 * Array for right join conditions
	 *
	 * @var		array
     */
	private $_rightJoin 	= array();

	/**
	 * Array for inner join conditions
	 *
	 * @var		array
     */
	private $_innerJoin 	= array();

	/**
	 * First where condition
	 *
	 * @var		string
     */
	private $_add 		= null;

	/**
	 * Other where and conditions
	 *
	 * @var		array
     */
	private $_addAnd 	= array();

	/**
	 * Other where or conditions
	 *
	 * @var		array
     */
	private $_addOr 	= array();

	/**
	 * Other where in conditions
	 *
	 * @var		array
     */
	private $_inArray	= array();

	/**
	 * Group by clause
	 *
	 * @var		string
     */
	private $_groupBy 	= null;

	/**
	 * Order by clause
	 *
	 * @var		string
     */
	private $_orderBy 	= array();

	/**
	 * Limit by clause
	 *
	 * @var		string
     */
	private $_limit 	= null;

    /**
     * Additional From.
	 * Usefull for selecting more then one table in a query.
	 *
     * @var		string
     */
	private $_from = '';

    /**
     * Debug queries and method parameters
	 *
     * @var		boolean
     */
	private $_debug = false;

    /**
     * Debug queries only
	 *
     * @var		boolean
     */
	private $_justQuery = false;
    
	/**
	 * Add some columns into a select statement
	 *
	 * @author	Claudio Walser
	 * @param 	mixed			Array with columns or sql string
	 * @return	boolean
	 */
	public function setCols($cols = null) {
		if ($this->_debug === true) {
			var_dump($cols);
		}
		if ($cols === null) {
			$cols = array();
		}
		if (empty($cols) || !is_array($cols)) {
			if (is_string($cols)) {
				$this->_cols = $cols;
			} else {
				$this->_cols = "*";
			}
		} else {
			$this->_cols = implode(", ", $cols);
		}
		return true;
	}

	/**
	 * Add some columns into a select statement
	 *
	 * @author	Claudio Walser
	 * @param 	mixed			Array with columns or sql string
	 * @return	boolean
	 */
	public function select($cols) {
		return $this->setCols($cols);
	}

	/**
	 * Adds another from
	 *
	 * This method just adds another from. Usually the from is coming
	 * from Query Class create method.
	 *
	 * @access	public
	 * @param 	mixed			Array with tablenames or dirctly the sql string. Care about the main table name, which is first for sure"
	 * @return	boolean
	 */
	public function addFrom($from) {
		if ($this->_debug === true) {
			var_dump($from);
		}
		if ($from === null) {
			$from = array();
		}
		if (!empty($from) && !is_array($from)) {
			if (is_string($from)) {
				$this->_from = $from;
			}
		} else if (!empty($from)) {
			$this->_from = implode(", ", $from);
		}
		return true;
	}
	public function from($from) {
		return $this->addFrom($from);
	}
	
	/**
	 * Sets a table alias
	 *
	 * Set a table alias for selectiong queries.
	 *
	 * @access	public
	 * @param 	string			Table alias
	 * @return	boolean
	 */
	public function selectTableAs($alias) {
		$this->_tableAlias = $alias;
		return true;
	}

	/**
	 * Get the columns of the select query
	 *
	 * @author	Claudio Walser
	 * @return	string
	 */
	public function getCols() {
		if (empty($this->_cols)) {
			throw new Exception("You cant call Criteria::getCols bevore you set any cols!");
		}
		$array = explode(",", $this->_cols);
		$return = array();
		if (is_array($array)) {
			foreach ($array as $key => $var) {
				$return[$key] = trim($var);
			}
		} else {
			$return[] = '*';
		}
		return $return;
	}

	/**
	 * Erstellt die erste WHERE Bedingung.
     *
	 * Falls bei einer Abfrage eine Where Bedingung erforderlich sein sollte,
	 * muss diese mit DbCriteria::add() eingeleitet werden.
	 * Danach kann sie mit addAnd() und addOr() beliebig erweitert werden.
	 * Diese Methode kann nur einmal aufgerufen werden.
     *
	 * @throws	Exception		Wirft eine Ausnahme wenn bereits eine WHERE Bedingung gesetzt ist
	 * @access	public
	 * @param	string			Spaltenname
	 * @param	string			Wert
	 * @param	string			Vergleichsoperator. Standardm�ssig auf '='
	 * @return	bool
     */
	/**
	 * Adds an where in condition
	 *
	 * This method adds a where in condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @param 	boolean		True for selectiong NOT IN ()			
	 * @return	boolean
	 */
	public function inArray($name, $value, $not = false) {
		$index = count($this->_inArray);
		$this->_inArray[$index]['name'] = $name;
		$this->_inArray[$index]['value'] = $value;
		$this->_inArray[$index]['not'] = $not;
		return true;
	}

	/**
	 * Adds a LEFT JOIN condition
	 *
	 * This method adds a LEFT JOIN condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Foreign tablenname			
	 * @param 	mixed		The ON condition			
	 * @return	boolean
	 */
	public function leftJoin($table, $condition) {
		$key = count($this->_leftJoin);
		$this->_leftJoin[$key]['table'] = $table;
		$this->_leftJoin[$key]['condition'] = $condition;
		return true;
	}

	/**
	 * Adds a RIGHT JOIN condition
	 *
	 * This method adds a RIGHT JOIN condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Foreign tablenname			
	 * @param 	mixed		The ON condition			
	 * @return	boolean
	 */
	public function rightJoin($table, $condition) {
		$key = count($this->_rightJoin);
		$this->_rightJoin[$key]['table'] = $table;
		$this->_rightJoin[$key]['condition'] = $condition;
		return true;
	}

	/**
	 * Adds a INNER JOIN condition
	 *
	 * This method adds a INNER JOIN condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Foreign tablenname			
	 * @param 	mixed		The ON condition			
	 * @return	boolean
	 */
	public function innerJoin($table, $condition) {
		$key = count($this->_innerJoin);
		$this->_innerJoin[$key]['table'] = $table;
		$this->_innerJoin[$key]['condition'] = $condition;
		return true;
	}

	/**
	 * Adds a where condition
	 *
	 * This method just adds a where and its condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @param 	string		Operator, default value is =			
	 * @return	boolean
	 */
	public function add($name, $value, $operator = '=') {
		if ($this->_add !== null) {
			throw new Exception("<strong><br />\nYou cant call Criteria::add if the WHERE clausel does already exists!<br />\n</strong>");
		}
		$this->_add = array();
		$this->_add['name'] = $name;
		$this->_add['value'] = $value;
		$this->_add['operator'] = $operator;
		return true;
	}
	
	public function where($name, $value, $operator = '=') {
		return $this->add($name, $value, $operator);
	}

	/**
	 * Adds an AND condition to an existent where
	 *
	 * This method just adds another where AND condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @param 	string		Operator, default value is =			
	 * @return	boolean
	 */
	public function addAnd($name, $value, $operator = '=') {
		if ($this->_add === null && count($this->_inArray) === 0) {
			throw new Exception("<strong><br />\nYou cant call Criteria::addAnd if the WHERE clausel does not exists!<br />\n</strong>");
		}
		$i = count($this->_addAnd);
		$this->_addAnd[$i]['name'] = $name;
		$this->_addAnd[$i]['value'] = $value;
		$this->_addAnd[$i]['operator'] = $operator;
		return true;
	}
	
	public function whereAnd($name, $value, $operator = '=') {
		return $this->addAnd($name, $value, $operator);
	}


	/**
	 * Adds an OR condition to an existent where
	 *
	 * This method just adds another where OR condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @param 	string		Operator, default value is =			
	 * @return	boolean
	 */
	public function addOr($name, $value, $operator = '=') {
		if ($this->_add === null) {
			throw new Exception("<strong><br />\nYou cant call Criteria::addAnd if the WHERE clausel does not exists!<br />\n</strong>");
		}
		$i = count($this->_addOr);
		$this->_addOr[$i]['name'] = $name;
		$this->_addOr[$i]['value'] = $value;
		$this->_addOr[$i]['operator'] = $operator;
		return true;
	}
	
	public function whereOr($name, $value, $operator = '=') {
		return $this->addOr($name, $value, $operator);
	}



	/**
	 * Adds a WHERE LIKE condition
	 *
	 * This method adds a WHERE LIKE condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @return	boolean
	 */
	public function like($name, $value) {
		$this->add($name, $value, 'LIKE');
		return true;
	}


	/**
	 * Adds a AND LIKE condition
	 *
	 * This method adds a AND LIKE condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @return	boolean
	 */
	public function likeAnd($name, $value) {
		$this->addAnd($name, $value, 'LIKE');
	}

	/**
	 * Adds a OR LIKE condition
	 *
	 * This method adds a OR LIKE condition
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Value			
	 * @return	boolean
	 */
	public function likeOr($name, $value) {
		$this->addOr($name, $value, 'LIKE');
	}

	/**
	 * Adds a LIMIT
	 *
	 * This method adds a LIMIT
	 * to the query. 
	 *
	 * @access	public
	 * @param 	int			Limit value			
	 * @param 	int			Offset value, default to 0		
	 * @return	boolean
	 */
	public function limit($limit, $offset = null) {
		$this->_limit['limit'] = $limit;
		$this->_limit['offset'] = $offset;
		return true;
	}

	/**
	 * Adds a ORDER BY
	 *
	 * This method adds a ORDER BY
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @param 	mixed		Direction: DESC = descending || ASC = ascending	. Default value ASC		
	 * @return	boolean
	 */
	public function orderBy($name, $dir = 'ASC') {
		$i = count($this->_orderBy);
		$this->_orderBy[$i]['name'] = $name;
		$this->_orderBy[$i]['dir'] = $dir;
		return true;
	}

	/**
	 * Adds a GROUP BY
	 *
	 * This method adds a GROUP BY
	 * to the query. 
	 *
	 * @access	public
	 * @param 	string		Columnname			
	 * @return	boolean
	 */
	public function groupBy($name) {
		$this->_groupBy = $name;
		return true;
	}

	/**
	 * Execute the query
	 *
	 * Creates the query and returns the model objects.
	 *
	 * @param	string			Tablename
	 * @param	\Spaf\Library\Orm\Runtime\Driver\Sql		Database driver instance
	 * @return	string			Query string
	 */
	public function prepare($table, \Spaf\Library\Orm\Runtime\Driver\Sql $dbh) {
		// check if table alias
		if ($this->_tableAlias !== null) {
			$table .= ' AS ' . $this->_tableAlias;
		}

		if (!empty($this->_from)) {
			$table .= ', ' . $this->_from;
		}

		$query = null;
		foreach ($this as $key => $value) {
			switch ($key) {
				case "_cols":
					/*if (is_array($this->_max) && count($this->_max) > 0) {
						foreach ($this->_max as $max) {
							$value .= ', MAX(' . $max . ')';
						}
					}*/
					if ($this->_type === "SELECT") {
						$query = "SELECT $value FROM $table" . "\n";
					} else {
						$query = "SELECT $value FROM $table" . "\n";
					}
					break;

				case "_leftJoin":
					if (!empty($this->_leftJoin)) {
						foreach ($this->_leftJoin as $join) {
							$query .= ' LEFT JOIN ' . $join['table'] . ' ON ' . $join['condition'] . "\n";
						}
					}
					break;

				case "_rightJoin":
					if (!empty($this->_rightJoin)) {
						foreach ($this->_rightJoin as $join) {
							$query .= ' RIGHT JOIN ' . $join['table'] . ' ON ' . $join['condition'] . "\n";
						}
					}
					break;

				case "_innerJoin":
					if (!empty($this->_innerJoin)) {
						foreach ($this->_innerJoin as $join) {
							$query .= ' INNER JOIN ' . $join['table'] . ' ON ' . $join['condition'] . "\n";
						}
					}
					break;


				case "_add":
					if (!empty($value)) {
						$query .= ' WHERE' . "\n";
						$query .= " " . $value["name"] . " " . $value["operator"] . " '" . $value["value"] . "'" . "\n";
					}
					break;

				case "_addAnd":
					if (is_array($value) && count($value) > 0) {
						foreach ($value as $_key => $_value) {
							$query .= " AND " . $_value["name"] . " " . $_value["operator"] . " '" . $_value["value"] . "'" . "\n";
						}
					}
					break;

				case "_addOr":
					if (is_array($value)) {
						foreach ($value as $_key => $_value) {
							$query .= " OR " . $_value["name"] . " " . $_value["operator"] . " '" . $_value["value"] . "'" . "\n";
						}
					}
					break;

				case "_inArray":
					if (is_array($value) && count($value) > 0) {
						if ($this->_add !== null) {
							$query .= ' AND';
						} else {
							$query .= ' WHERE';
						}
						$i = 0;
						foreach ($value as $_key => $_value) {
							if ($i > 0) {
								$query .= ' AND';
							}
							$query .= " " . $_value["name"];
							if ($_value["not"] === true) {
								$query .= " NOT";
							}
							$query .= " IN ('" . implode("', '", $_value["value"]) . "')" . "\n";
							$i++;
						}
					}
					break;

				case "_groupBy":

					if (!empty($value)) {
						$query .= " GROUP BY " . $value . "\n";
					}

					break;

				case "_orderBy":
					$count = count($value);
					if (is_array($value) && $count > 0) {
						$query .= ' ORDER BY ';
						$i = 1;
						foreach ($value as $_key => $_value) {
							$query .= ' ' . $_value['name'] . ' ' . $_value['dir'];
							if ($i < $count) {
								$query .= ',';
							} else {
								$query .= "\n";
							}
							$i++;
						}
					}
					break;


				case "_limit":
					if (!empty($value)) {
						$query .= $dbh->getLimit($value['limit'], $value['offset']) . "\n";
					}
					break;

				default:
					break;
			}
		}
		if ($this->_debug === true || $this->_justQuery === true) {
			echo $query . "<br />\n";
		}
		return $query;
	}

	/**
	 * Checks if a where condition already exists
     *
	 * @return	boolean
     */
	public function issetWhere() {
		return $this->_add !== null || count($this->_inArray) > 0;
	}
	
	/**
	 * Checks if some columns for reading are selected
     *
	 * @return	boolean
     */
	public function issetCols() {
		try {
			$this->getCols();
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
	
	/**
	 * Set debugging
	 *
	 * Set debugging to true or false.
	 * Also you can define to just show the query debugging echos.
	 * Per Default you will see datatypes of method parameters and 
	 * many other stuff.
	 *
	 * @access	public
	 * @param 	boolean		Debug true or false			
	 * @param 	boolean		Debug just queries, default value false			
	 * @return	boolean
	 */
	public function debug($bool, $justQuery = false) {
		$this->_debug = (bool) $bool;
		$this->_justQuery = (bool) $justQuery;
	}
}
?>