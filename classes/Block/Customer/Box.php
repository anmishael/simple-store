<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 02.04.13
 * Time: 0:52
 * To change this template use File | Settings | File Templates.
 */
class Block_Customer_Box extends Block_Display {
	var $_customer;
	function init() {
		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
		if($this->_customer instanceof Model_Customer) {
			if(!$this->_params['blockname']) {
				$this->_blockname = 'contentleft';
			}
			$this->fetch('customer', 'box');
		}
		return $this;
	}
}
