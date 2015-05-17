<?php
/*
 * Created on 11 черв. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
 
 class Block_Product_Feedback extends Block_Display {
 	var $_customer;
 	var $_product;
 	function init() {
 		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		if(!is_object($this->_customer) || !$this->_customer instanceof Model_Customer) {
 			$this->_customer = $this->_core->getModel('Customer')->newInstance();
 		}
 		if((int)$this->_core->getRequest('pid')>0) {
 			$this->_product = $this->_core->getModel('Product/Collection')->newInstance()
 					->addFilter('p.id', (int)$this->_core->getRequest('pid'), 'eq')
 					->getOne();
 		}
 		if(!is_object($this->_product) || !$this->_product instanceof Model_Product) {
 			$this->_product = $this->_core->getModel('Product')->newInstance();
 		}
 		$this->fetch('product', 'feedback');
 		return $this;
 	}
 }