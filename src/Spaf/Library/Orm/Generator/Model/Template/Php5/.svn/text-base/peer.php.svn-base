
/**
 * Class {uc_tablename}Query
 * The {tablename} database class.
 */
abstract class {uc_tablename}Query extends {uc_tablename}Base {


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
			throw new DbException('{uc_tablename}Query::retrieveByPk FatalError: First argument has to be a array with equivalent number of elements like the primary keys of this table!');
		} 
		
		// ensure $c is a DbCriteria object
		if (get_class($c) !== 'DbCriteria') {
			$c = new DbCriteria();
		}
		
		// set all cols if they are'nt set yet
		try {
			$c->getCols();
		} catch (DbException $e) {
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
		self::$_dbh = DbManager::getConnection(self::$_dsn);
		// send query and return the object or null
		self::$_dbh->executeQuery($c->prepare(self::TABLENAME, self::$_dbh));
		$objs = self::$_dbh->getResultArray();
		return $objs !== null ? new {uc_tablename}($objs[0]) : null;
	}

	/**
	 * Function doSelect()
	 * Retrieve some {uc_tablename} Objects by a DbCriteria Object.
	 */
	public static function doSelect($c = null) {
		// ensure $c is a DbCriteria
		if (!$c instanceof DbCriteria) {
			$c = new DbCriteria();
		}
		
		// set all cols if they are'nt set yet
		try {
			$c->getCols();
		} catch (DbException $e) {
			$c->setCols(self::$cols);
		}
		
		// get database connection and execute the query
    	self::$_dbh = DbManager::getConnection(self::$_dsn);
		self::$_dbh->executeQuery($c->prepare(self::TABLENAME, self::$_dbh));
		
		$objs = array();
		$o = self::$_dbh->getResultArray();
		if ($o === null) {
			return null;
		}
		
		foreach ($o as $obj) {
			array_push($objs, new {uc_tablename}($obj));
		}
		return $objs;
	}
    
}
