<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_User_Type_Edit extends Block_Display {
 	var $_item;
 	function init() {
 		$this->arrControllers = $this->_core->getSingleton('Controller')->getAllControllers('Admin');
		
 		$this->_item = $this->_core->getModel('User/Type/Collection')->getUserType($this->_core->getRequest('id'));
 		$this->fetch('user/type', 'edit');
 		return $this;
 	}
 }