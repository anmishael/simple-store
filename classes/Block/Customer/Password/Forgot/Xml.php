<?php
/*
 * Created on 26 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Block_Customer_Password_Forgot_Xml extends Block_Display {
	function init() {
		$this->fetch('customer', 'password/forgot/xml');
		return $this;
	}
}