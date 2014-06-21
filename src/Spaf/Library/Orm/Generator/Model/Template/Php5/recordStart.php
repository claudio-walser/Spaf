
/**
 * Class {uc_tablename}Record
 * The {tablename} database class. Objects from this class can be created from the fly to insert a new object
 * or retrieved by {uc_tablename}Query Class.
 */
class {uc_tablename}Record extends {uc_tablename}Base {

{columns}

{nm_properties}
	
	/**
	 * Is it a new object? If yes, set insert to true.
	 *
	 * @var		boolean
	 * @access	private
	 */
	private $_insert = true;

	/**
	 * Stores all data for debugging in toString interzeptor.
	 *
	 * @var		array
	 * @access	private
	 */
	protected $_data = array();

	/**
	 * All specail attributes like «COUNT(*) AS count»
	 *
	 * @var		array
	 * @access	private
	 */
	protected $_attributes = array();

	/**
	 * Function __construct()
	 * Call the parent constructor for setting up dsn.
     * Check data and create a object from a existing database record.
     * Set $this->_insert to false in this case to update this record.
     *
	 * @access        public
	 */
	public function __construct($data = null) {
		parent::__construct();
		if ($data !== null) {
			$this->_insert = false;
			$this->_data = $data;
            foreach ($data as  $key => $value) {
{constructDataSwitch}
			}
		}
	}

