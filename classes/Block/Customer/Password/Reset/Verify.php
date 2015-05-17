<?php
/*
 * Created on 25 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Customer_Password_Reset_Verify extends Block_Display {
 	var $_code;
 	function init() {
 		$this->_code = $this->_core->getRequest('code');
 		$this->fetch('customer', 'password/reset/verify');
 		return $this;
 	}
 }