<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 29.03.13
 * Time: 14:51
 * To change this template use File | Settings | File Templates.
 */
class Block_Admin_Customer_Status_Xml extends Block_Display {
	var $_item;
	function init() {
		$this->_item = $this->_core->getModel('Customer/Collection')->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if(!$this->_item instanceof Model_Customer) {
			$this->_item = $this->_core->getModel('Customer')->newInstance();
		}
		$this->fetch('customer', 'status/xml');
	}
}
