<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Resource_DB_Abstract {
	function __construct() {
		$this->_core = Core::getSingleton('Core');
	}
	function connect() {
		$this->_connect();
	}
	function disconnect() {
		$this->_disconnect();
	}
	function raiseError() {
		if($this->debug>1) {
			$this->_core->raiseError('MySQL error ['. mysql_errno($this->_conn).']: ' . mysql_error($this->_conn) . '<br />Query: ' . $this->_sql);
		} elseif($this->debug>0) {
			$code = 'DB_ERROR_' . mysql_errno($this->_conn);
			$this->_core->raiseError($this->_core->getModel('Translate/Collection')->get($code)->get('value')!=$code?$this->_core->getModel('Translate/Collection')->get($code)->get('value'):mysql_error($this->_conn));
		}
	}
}