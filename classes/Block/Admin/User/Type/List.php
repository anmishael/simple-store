<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_User_Type_List extends Block_Display {
 	var $_items;
 	function init() {
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('User', 'TypeList')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-type-edit'),
	 				'name'=>'edit'
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-type-edit'),
	 				'name'=>'Add new usertype'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('User', 'TypeRemove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-type-remove'),
	 				'name'=>'remove',
	 				'warning'=>'Are you sure you wish to remove "%s" usertype?'
	 			);
 		}
 		$this->_items = $this->_core->getModel('User/Type/Collection')->getCollection();
 		$this->fetch('user/type', 'list');
 		return $this;
 	}
 }