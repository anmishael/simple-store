<?php
/*
 * Created on May 24, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_UserDetails extends Block_Display {
 	var $_user;
 	function init() {
 		$this->_user = $this->_core->getModel('User/Collection')->getCurrentUser();
 		$this->_blockname = 'userdetails';
 		$this->fetch('default', 'userdetails');
 		return $this;
 	}
 }