namespace {model_namespace}\Base;

abstract class {uc_tablename} extends DataSourceName {

{constants}


	/**
	 * All columns as static array.
	 * @access        public
	 */
	public static $cols = array({self_columns});

	/**
	 * All primary key columns as static array.
	 * @access        public
	 */
	public static $pkCols = array({self_pk_columns});

	/**
	 * The database handler.
	 * @access        protected
	 */
	protected static $_dbh 	= null;


	protected function __construct() {
		self::$_dbh = \{runtime_namespace}\Manager::getConnection(self::$_dsn);
	}
}
