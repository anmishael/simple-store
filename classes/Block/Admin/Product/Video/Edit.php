<?php
/*
 * Created on 5 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Product_Video_Edit extends Block_Display {
 	var $_item;
 	function init() {
 		if($this->_core->getRequest('id') && $this->_core->getRequest('pid')) {
 			$this->_item = $this->_core->getModel('Product/Video/Collection')->newInstance()
 					->addFilter('pid', $this->_core->getRequest('pid'), 'eq')
 					->addFilter('id', $this->_core->getRequest('id'), 'eq')
 					->getCollection();
 			if(isset($this->_item[0]) && $this->_item[0] instanceof Model_Product_Video) {
 				$this->_item = $this->_item[0];
 				$this->fetch('product', 'video/edit');
 			}
 		}
 		return $this;
 	}
 }