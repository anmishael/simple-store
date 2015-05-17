<?php
/**
 * Created on 17 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Customer_View extends Block_Display {
	var $_customer;
	var $_favorites;
	var $_status;
	var $_orders;
	var $_limit = 10;
	function init() {
		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
		$type = $this->_core->getModel('Customer/Type/Collection')->newInstance()
			->addFilter('id', $this->_customer->get('typeid'), 'eq')
			->getOne();
		$coll = $this->_core->getModel('Order/Collection')
			->addFilter('cid', $this->_customer->get('id'), 'eq')
			->setOrder('created')
			->setOrderWay('DESC');
		$total = clone($coll);
		$total = $total->getTotal();
		$coll->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit);
		$this->_orders = $coll->getCollection();
		$this->_totalpages = ceil($total/$this->_limit);

		$this->fetch('customer', 'view/' . strtolower($type->get('name')));
		return $this;
	}
}