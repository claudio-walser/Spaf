namespace {model_namespace}\Query;

/**
 * Class {uc_tablename}Query
 * The {tablename} database class.
 */
abstract class {uc_tablename} extends \{model_namespace}\Base\{uc_tablename} {
	
    public static function create() {
		$closure = function($c) {
			return \{model_namespace}\Query\{uc_tablename}::doSelect($c);
		};
    	$query = new \{runtime_namespace}\Query\FluentInterface($closure);
		return $query;
    }

	/**
	 * Function retrieveByPk()
	 * Retrieve one {uc_tablename} Object by primary key.
     * As second optional parameter cou could input also a DbCriteria Object.
	 */
	public static function retrieveByPk($pk, $c = null) {
		// ensure thats $primaryKey is a array
		$primaryKey = array();
        if (!is_array($pk)) {
			$primaryKey[0] = $pk;
		} else {
        	$primaryKey = $pk;
        }

		// Are there so much pk-arguments like pk-columns?
		if (count($primaryKey) !== count(self::$pkCols)) {
			throw new \{runtime_namespace}\Exception('{uc_tablename}Query::retrieveByPk FatalError: First argument has to be a array with equivalent number of elements like the primary keys of this table!');
		}

		// ensure $c is a DbCriteria object
		if (!$c instanceof \{runtime_namespace}\Query\Criteria) {
			$c = new \{runtime_namespace}\Query\Criteria();
		}

		// set all cols if they are'nt set yet
		try {
			$c->getCols();
		} catch (\{runtime_namespace}\Query\Exception $e) {
			$c->setCols(self::$cols);
		}

		// set the primary keys in where clausel
		foreach (self::$pkCols as $key => $col) {
			// add primary key to as where clause to criteria object
			if ($c->issetWhere() === true) {
				$c->addAnd($col, $primaryKey[$key]);
			} else {
				$c->add($col, $primaryKey[$key]);
			}
		}

		// get database connection
		self::$_dbh = \{runtime_namespace}\Manager::getConnection(self::$_dsn);
		// send query and return the object or null
		self::$_dbh->executeQuery($c->prepare(self::TABLENAME, self::$_dbh));
		$objs = self::$_dbh->getResultArray();
		return $objs !== null ? new \{model_namespace}\{uc_tablename}($objs[0]) : null;
	}

	/**
	 * Function doSelect()
	 * Retrieve some {uc_tablename} Objects by a \{runtime_namespace}\Query\Criteria Object.
	 */
	public static function doSelect($c = null) {
		// ensure $c is a \{runtime_namespace}\Query\Criteria
		if (!$c instanceof \{runtime_namespace}\Query\Criteria) {
			$c = new \{runtime_namespace}\Query\Criteria();
		}

		// set all cols if they are'nt set yet
		try {
			$c->getCols();
		} catch (\{runtime_namespace}\Query\Exception $e) {
			$c->setCols(self::$cols);
		}

		// get database connection and execute the query
    	self::$_dbh = \{runtime_namespace}\Manager::getConnection(self::$_dsn);
		self::$_dbh->executeQuery($c->prepare(self::TABLENAME, self::$_dbh));

		$objs = array();
		$o = self::$_dbh->getResultArray();
		if ($o === null) {
			return null;
		}

		foreach ($o as $obj) {
			array_push($objs, new \{model_namespace}\{uc_tablename}($obj));
		}
		return $objs;
	}

}
