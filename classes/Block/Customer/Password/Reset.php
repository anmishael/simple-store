<?php
/*
 * Created on 25 лип. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Customer_Password_Reset extends Block_Display {
 	function init() {
 		$this->fetch('customer', 'password/reset');
 		return $this;
 	}
 }