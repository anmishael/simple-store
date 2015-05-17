<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.03.13
 * Time: 17:12
 * To change this template use File | Settings | File Templates.
 */
class Block_Admin_Customer_Pricegroup_Edit extends Block_Display {
	var $_item;
	function init() {
		if($this->_core->getRequest('id')) {
			$this->_item = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
		}
		if(!$this->_item instanceof Model_Customer_Pricegroup) {
			$this->_item = $this->_core->getModel('Customer/Pricegroup')->newInstance();
		}
		$this->fetch('customer', 'pricegroup/edit');
	}
}
