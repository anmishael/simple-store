<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Customer_Type extends Model_Object {
 	var $_table = 'customer_types';
 	var $_id = 'id';
 	var $_model = 'Customer/Type';
 	function getPermissions() {
		if($this->get('permissions') && !is_array($this->get('permissions'))) {
			$this->set('permissions', unserialize($this->get('permissions')));
		}
		return $this->get('permissions');
	}
	function save() {
 		$res = false;
 		
 		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('customer_types');
 		$data = $this->_data;
 		foreach($data as $k=>$v) {
 			if(!in_array($k, $columns)) unset($data[$k]);
 		}
 		if($data['permissions'] && is_array($data['permissions'])) {
 			$data['permissions'] = serialize($data['permissions']);
 		}
 		if($this->get('id')) {
 			$this->_core->getModel('Customer/Type/Collection');
 			$pc = new Model_Customer_Type_Collection();
 			$pc->addFilter('id', $this->get('id'), 'eq');
 			$res = $this->_core->getResource('DB')->getConnection()->update('customer_types', $data, $pc);
 		} else {
 			$res = $this->_core->getResource('DB')->getConnection()->insert('customer_types', $data);
 		}
 		return $res;
	}
	function remove() {
 		$query = 'DELETE FROM `customer_types` WHERE id=\'' . $this->get('id') . '\'';
 		$this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();
 		return $this;
 	}
 }