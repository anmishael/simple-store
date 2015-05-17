<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Resource_DB {
	var $_core, $_conn, $_db_type, $_obj;
	function __construct() {
		$this->_core = Core::getSingleton('Core');
		$this->_db_type = $this->_core->getSingleton('Config')->DB['type'];
		$this->_obj = $this->_core->getResource('DB/' . $this->_db_type);
		if(!is_object($this->_obj)) {
			die('Missing resource "DB/' . $this->_db_type.'"');
		}
		$this->_conn = $this->getConnection()->connect();
	}

	/**
	 * @return mixed|Resource_DB_MySQL
	 */
	function getConnection() {
		return $this->_obj;
	}
	function __destruct() {
		$this->getConnection()->disconnect();
	}
}