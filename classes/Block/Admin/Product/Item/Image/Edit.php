<?php
/*
 * Created on 24 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Product_Item_Image_Edit extends Block_Display {
 	var $_item;
 	var $_types;
 	function init() {
 		if($this->_core->getRequest('pid') && $this->_core->getRequest('piid') && $this->_core->getRequest('id')) {
 			$this->_core->getModel('Product/Item/Image');
 			if($this->_core->getRequest('id')) {
 				$this->_item = $this->_core->getModel('Product/Item/Image/Collection')->newInstance()
 						->addFilter('pid', $this->_core->getRequest('pid'), 'eq')
 						->addFilter('piid', $this->_core->getRequest('piid'), 'eq')
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getCollection();
 				if(is_object($this->_item[0]) && $this->_item[0] instanceof Model_Product_Item_Image) {
 					$this->_item = $this->_item[0];
 				} else {
 					$this->_item = new Model_Product_Item_Image(array('pid'=>$this->_core->getRequest('pid'), 'piid'=>$this->_core->getRequest('piid')));
 				}
 			} else {
 				$this->_item = new Model_Product_Item_Image(array('pid'=>$this->_core->getRequest('pid'), 'piid'=>$this->_core->getRequest('piid')));
 			}
 			$this->_types = $this->_core->getModel('Product/Image/Type/Collection')->newInstance()->getCollection();
 			$this->fetch('product', 'item/image/edit');
 		}
 		return $this;
 	}
 }