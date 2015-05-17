<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Customer_Type_List extends Block_Display {
 	var $_items;
 	function init() {
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'TypeList')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-customer-type-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-customer-type-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_CUSTOMER_TYPE', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'TypeRemove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-customer-type-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" customertype?'
	 			);
 		}
 		$this->_items = $this->_core->getModel('Customer/Type/Collection')->getCollection();
 		$this->fetch('customer/type', 'list');
 		return $this;
 	}
 }