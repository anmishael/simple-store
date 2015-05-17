<?php
/*
 * Created on May 27, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_User_Edit extends Block_Display {
 	var $_item;
 	var $_types;
 	function init() {
 		$this->_core->getModel('User');
 		$this->_item = new Model_User();
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('User/Collection')->clear()->getUser($this->_core->getRequest('id'));
 		}
 		$this->_types = $this->_core->getModel('User/Type/Collection')->getCollection();
 		$this->fetch('user', 'edit');
 		return $this;
 	}
 }