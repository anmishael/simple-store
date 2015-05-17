<?php
/*
 * Created on May 27, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_User_List extends Block_Display {
 	var $_items;
 	var $_types;
 	var $_arrtypes = array();
 	function init() {
 		$this->_core->getModel('User/Collection');
 		$coll = new Model_User_Collection();
 		$this->_items = $coll->getCollection();
 		$this->_types = $this->_core->getModel('User/Type/Collection')->getCollection();
 		foreach($this->_types as $k=>$v) {
 			$this->_arrtypes[$v->get('id')] = $v->toArray(); 
 		}
 		
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('User', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_USER', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('User', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-user-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" user?'
	 			);
 		}
 		
 		$this->fetch('user', 'list');
 		return $this;
 	}
 }