namespace {model_namespace}\Base;

abstract class DataSourceName {

	protected static $_dsn = array(	'dbdriver' => {sql_driver},
									'hostname' => {host},
									'port' => {port},
									'username' => {user},
									'password' => {pass},
									'database' => {name});


	public static function getDsn() {
		return self::$_dsn;
	}


	/**
	 * __toString().
	 * Implements for calling print and/or echo on a object of this class.
	 */
	public function __toString() {
		$className = get_class($this);

		$string = '<h1>' . $className . '</h1>';

		$reflection = new ReflectionClass($className);
		$constants = $reflection->getConstants();
        $string .= '<h2>Constants</h2>';
		$i = 0;
		foreach ($constants as $key => $constant) {
			$string .= "    " . '[' . $i . '] => ' . $key . "\n";
			$i++;
		}

        $string .= '<h2>Methods</h2>';
		$i = 0;
		$methods = $reflection->getMethods();
		foreach ($methods as $method) {
			$string .= "    " . '[' . $i . '] => ' . $method->name . "\n";
			$i++;
		}


		$string .= '<h2>Data</h2>';
		$string .= print_r($this->_data, 1);

		$string .= '<h2>Attribute</h2>';
		$string .= print_r($this->_attributes, 1);

		return '<pre>' . $string . '</pre>';
	}

	public function getData() {
    	$this->_data['attributes'] = $this->_attributes;
		return $this->_data;
	}

	public function getAttribute($key) {
		return isset($this->_attributes[$key]) ? $this->_attributes[$key] : null;
	}
}