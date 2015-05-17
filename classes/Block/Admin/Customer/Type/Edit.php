<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Block_Admin_Customer_Type_Edit extends Block_Display {
	var $_item;
	var $_prices;
	function init() {
		$this->arrControllers = $this->_core->getSingleton('Controller')->getAllControllers();
		$this->_prices = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()->getCollection();
		$this->_item = $this->_core->getModel('Customer/Type/Collection')->getCustomerType($this->_core->getRequest('id'));
		$this->fetch('customer/type', 'edit');
		return $this;
	}
}