<?php
/**
 * Created on 20 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Message_View extends Block_Display {
 	var $_items;
 	var $_item;
 	var $_user;
 	function init() {
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 					->addFilter('id', $this->_core->getRequest('id'), 'eq')
 					->getOne();
 			$this->_item->push('is_read', 1)->save();
 			if($this->_item instanceof Model_Customer_Support_Message) {
 				$this->_user = $this->_core->getModel('User/Collection')->getCurrentUser();
 				$this->_items = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()->clear();
 				$this->_fillItems($this->_item->get('id'));
 				$this->_items = $this->_items->returnCollection();
 				$this->fetch('message', 'view');
 			}
 		}
 		return $this;
 	}
 	function _fillItems($id) {
 		$items = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 					->addFilter('parent', $id, 'eq')
 					->getCollection();
 		foreach($items as $k=>$item) {
 			$this->_items->put($item);
 			$this->_fillItems($item->get('id'));
 		}
 		return $this;
 	}
 }