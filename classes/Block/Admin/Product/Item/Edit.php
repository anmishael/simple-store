<?php
/**
 * Created on 17 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Product_Item_Edit extends Block_Display {
 	var $_item;
 	var $_imagetypes;
 	function init() {
 		if($this->_core->getRequest('pid')) {
 			$this->_core->getModel('Product/Item');
 			if($this->_core->getRequest('id')) {
 				$this->_item = $this->_core->getModel('Product/Item/Collection')->newInstance()
 						->addFilter('pid', $this->_core->getRequest('pid'), 'eq')
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getCollection();
 				if(is_object($this->_item[0]) && $this->_item[0] instanceof Model_Product_Item) {
 					$this->_item = $this->_item[0];
 					$this->_item->fetchImages();
 				} else {
 					$this->_item = new Model_Product_Item(array('pid'=>$this->_core->getRequest('pid')));
 				}
 			} else {
 				$this->_item = new Model_Product_Item(array('pid'=>$this->_core->getRequest('pid')));
 			}
 			
 			if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'Item/Image/Edit')) {
		 		$this->_actions[] = array(
		 				'url'=>$this->_core->getActionUrl('admin-product-item-image-edit'),
		 				'name'=>'edit'
		 			);
	 		}
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'Item/Image/Remove')) {
		 		$this->_actions[] = array(
		 				'url'=>$this->_core->getActionUrl('admin-product-item-image-remove'),
		 				'name'=>'remove',
		 				'warning'=>'Are you sure you wish to remove "%s" image?'
		 			);
	 		}
 			$this->_imagetypes = $this->_core->getModel('Product/Image/Type/Collection')->newInstance()->getCollection('id');
 			$this->fetch('product', 'item/edit');
 		}
 		return $this;
 	}
 }