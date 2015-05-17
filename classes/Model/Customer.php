<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Customer extends Model_Object {
 	var $_table = 'customers';
 	var $_id = 'id';
 	function authorize($email, $password) {
		$res = $this->_core->getModel('Customer/Collection')->newInstance()
				->addGroupFilter('username', 'email', $email, 'eq')
				->addGroupFilter('username', 'cardcode', $email, 'eq')
				->addFilter('password', $this->generatePassword($password), 'eq')
				->addFilter('status', 1, 'eq')
				->getOne();
		if(is_object($res) && $res instanceof Model_Customer) {
			$this->setData($res->toArray());
		}
		return $this;
	}
	function generatePassword($pass) {
		return md5($pass);
	}
	function save($fields = array()) {
		if($this->get('password') && $this->get('password_confirm')) {
			if($this->get('password') != $this->get('password_confirm')) {
				$this->_core->raiseError('Password confirm did not mutch password.');
			} else {
				$this->set('password', $this->generatePassword($this->get('password')));
			}
		} else {
			$this->pop('password');
			$this->pop('password_confirm');
		}
		$data = $this->toArray();
		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('customers');
 		foreach($data as $k=>$v) {
 			if(!in_array($k, $columns) || (sizeof($fields)>0 && !in_array($k, $fields))) unset($data[$k]);
 		}
		if($this->get('id')) {
 			$this->_core->getModel('Customer/Collection');
 			$pc = new Model_Customer_Collection();
 			$pc->addFilter('id', $this->get('id'), 'eq');
 			$res = $this->_core->getResource('DB')->getConnection()->update('customers', $data, $pc);
 		} else {
 			$res = $this->_core->getResource('DB')->getConnection()->insert('customers', $data);
 		}
 		return $res;
	}
	function checkPermission($action, $method) {
		$action = ucfirst($action);
		$strlen = strlen('action');
		if(substr($method, 0, $strlen) == 'action') {
			$method = substr($method, strlen('action'));
		}
		$res = false;
		if(!$this->get('permissions')) {
			$this->_core->getModel('Customer/Type/Collection');
			$coll = new Model_Customer_Type_Collection();
			$this->set('permissions', $coll->getCustomerType($this->get('typeid'))->getPermissions());
		}
		$arrPerm = $this->get('permissions');
		if((isset($arrPerm[$action]) || $action == 'Index') && (isset($arrPerm[$action][$method]) || $method=='Index')) {
			$res = true;
		}
		return $res;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	}
	function updateCart() {
		$this->push('shopping_cart', serialize($this->_core->getModel('Cart')->getProducts()));
		$this->save(array('shopping_cart'));
		return $this;
	}
 	function remove() {
 		$query = 'DELETE FROM `customers` WHERE id=\'' . $this->get('id') . '\'';
 		$this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();
 		
 		return $this;
 	}
 }