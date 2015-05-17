<?php
/**
* Created on 18 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/

class Block_Customer_LoginBox extends Block_Display {
	var $_customer;
	function init() {
		if(!$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) {
			$this->_blockname = 'contentleft';
			$this->fetch('customer', 'loginbox');
		}
		return $this;
	}
}