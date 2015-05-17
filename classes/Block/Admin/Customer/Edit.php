<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Customer_Edit extends Block_Display {
 	var $_item;
 	var $_types;
 	function init() {
 		$this->_core->getModel('Customer');
 		$this->_item = new Model_Customer();
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('Customer/Collection')->clear()->getCustomer($this->_core->getRequest('id'));
 		}
		$this->_prices = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()->getCollection();
 		$this->_types = $this->_core->getModel('Customer/Type/Collection')->getCollection();
 		$this->fetch('customer', 'edit');
 		return $this;
 	}
 }