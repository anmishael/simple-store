<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.02.13
 * Time: 14:49
 * To change this template use File | Settings | File Templates.
 */

class Block_Admin_Product_Status_Xml extends Block_Display {
	var $_item;
	function init() {
		$this->_item = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if(!$this->_item instanceof Model_Product) {
			$this->_item = $this->_core->getModel('Product')->newInstance();
		}
		$this->fetch('product', 'status/xml');
	}
}
