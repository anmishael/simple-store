<?php
/*
 * Created on May 23, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Language_List extends Block_Display {
 	var $_items = array();
 	var $_actions = array();
 	var $_toplinks = array();
 	function init() {
 		$this->_items = $this->_core->getModel('Language/Collection')->getCollection();
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Language', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-language-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-language-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_LANGUAGE', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Language', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-language-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" language?'
	 			);
 		}
 		$this->fetch('language', 'list');
 		return $this;
 	}
 }