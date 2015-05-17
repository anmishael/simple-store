<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_State_List extends Block_Display {
 	var $_items;
 	function init() {
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('State', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-edit'),
	 				'name'=>'edit'
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-edit'),
	 				'name'=>'Add new state'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('State', 'CityList')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-city-list'),
	 				'get'=>'_s=%s',
	 				'name'=>'view cities'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('State', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-remove'),
	 				'name'=>'remove',
	 				'warning'=>'Are you sure you wish to remove "%s" state?'
	 			);
 		}
 		$this->_items = $this->_core->getModel('State/Collection')->clear()->getCollection();
 		$this->fetch('state', 'list');
 	}
 }