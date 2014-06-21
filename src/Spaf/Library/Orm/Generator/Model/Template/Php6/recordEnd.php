
	/**
	 * Save the current object state
	 */
	public function doSave() {
		// @todo	Transaction needed?

		// Save the object state with all columns.
		if ($this->_insert === true) {
			$this->_doInsert();
		} else {
			$this->_doUpdate();
		}

		$this->_saveChilds();
		$this->_overwriteChilds();

		// @todo	also save other attributes in n:m dependency tables
	}

	// ok
	private function _doInsert() {
		$query = 'INSERT INTO ' . self::TABLENAME . ' ({columns}) VALUES ({values})';
		$r = self::$_dbh->executeQuery($query);
		if ($r !== false) {
        	$this->_id = self::$_dbh->getAutoIncrementValue();
			$this->_insert = false;
        }
		return $r;
	}
	// ok
	private function _doUpdate() {
		$query = 'UPDATE ' . self::TABLENAME . ' SET
				   {update_values}
					WHERE {where_pk}';
		return self::$_dbh->executeQuery($query);
	}

	private function _saveChilds() {
		// @todo	Transaction needed?
{save_childs}
	}

	private function _overwriteChilds() {
		// @todo	Transaction needed?
{overwrite_childs}
	}




	/**
	 * Delete this object out of database
	 */
	public function doDelete() {
		// start transaction
		self::$_dbh->begin();
		$this->_deleteChilds();
		$this->_deleteParents();
        // delete this object
		try {
			$query = 'DELETE FROM ' . self::TABLENAME . '
						WHERE {pk_loop}';

			self::$_dbh->executeQuery($query);
		} catch (\{runtime_namespace}\Driver\Exception $e) {
			// rollback transaction and throw \Cwa\Library\Database\Driver\
			self::$_dbh->rollback();
			throw new \{runtime_namespace}\Driver\Exception($e->getMessage());
		}
		// commit transaction
		return self::$_dbh->commit();
	}

	/**
	 * Delete child or setting foreign column with null
	 */
    private function _deleteChilds() {
{delete_childs}
    }

	/**
	 * Delete parent or setting foreign column with null
	 */
    private function _deleteParents() {
{delete_parents}
    }

    public function getData() {
    	return $this->_data;
    }
}
