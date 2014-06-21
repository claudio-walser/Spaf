	
	// set {columnname} value
	{access} function set{uc_columnname}($value) {
        $this->_data['{columnname}'] = $value;
		$this->_{columnname} = $value;
	}
	
	// get {columnname} value
	{access} function get{uc_columnname}() {
        return $this->_{columnname};
	}
