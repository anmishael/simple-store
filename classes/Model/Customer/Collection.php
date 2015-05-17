<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Customer_Collection extends Model_Collection_Abstract {
 	var $_currentCustomer;
 	var $_table = 'customers';
 	var $_id = 'id';
 	var $_model = 'Customer';
	function Model_Customer_Collection() {
		parent::__construct();
		$this->_core->getModel('Customer');
	}
	function getCustomer($id) {
//		if($this->size() == 0) {
 			$query = 'SELECT c.* ' .
 					'FROM `customers` c ';
 			if($id && is_numeric($id)) {
 				$this->addFilter('id', $id, 'eq');
	 			if(sizeof($this->_filter)>0) {
	 				$query .= ' WHERE ' . $this->_core->getResource('DB')->getConnection()->getFilterSql($this);
	 			}
	 			if($this->_limit) {
	 				$query .= ' LIMIT ' . $this->_limit;
	 			}
	 			$this->_core->getResource('DB')->getConnection()->setQuery($query);
	 			$customer= $this->_core->getResource('DB')->getConnection()->getResult('Customer');
	 			$customer = $customer[0];
 			}
// 		}
		return $customer;
	}
	function clearCurrentCustomer() {
		$this->_currentCustomer = null;
		return $this;
	}
	function getCurrentCustomer() {
		if((!$this->_currentCustomer || !is_object($this->_currentCustomer) || !$this->_currentCustomer->get('typeid')) && isset($_SESSION['customerid'])) {
			$this->_currentCustomer = $this->getCustomer($_SESSION['customerid']);
		}
		if(!$this->_currentCustomer instanceof Model_Customer) {
			$ct = $this->_core->getModel('Customer/Type/Collection')->newInstance()->addFilter('name', 'Unregistered', 'eq')->getCollection();
			if(isset($ct[0]) && $ct[0] instanceof Model_Customer_Type) {
				$ct = $ct[0];
			} else {
				$this->_core->raiseError('`Unregistered` customer type is not found on database. Please ask system administrator to fix this issue.');
			}
			$this->_currentCustomer = new Model_Customer(array('typeid'=>$ct->get('id')));
		} else {
			$prGroupID = $this->_currentCustomer->get('pricegroup');
			if(!$prGroupID) {
				$ct = $this->_core->getModel('Customer/Type/Collection')->newInstance()->addFilter('id', $this->_currentCustomer->get('typeid'), 'eq')->getOne();
				$prGroupID = $ct->get('pricegroup');
			}
			$prGroup = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()
				->addFilter('id', $prGroupID, 'eq')
				->getOne();
			if($prGroup instanceof Model_Customer_Pricegroup) {
				$this->_currentCustomer->push('pricegroupfield', $prGroup->get('field'));
			}
		}
		return $this->_currentCustomer;
	}
	function setCurrentCustomer($customer) {
		if($customer instanceof Model_Customer && $customer->get('id')) {
			$this->_currentCustomer = $customer;
		}
		return $this->_currentCustomer;
	}
 }