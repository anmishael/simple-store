<?php
/**
 * Created on 24 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Customer_View_Xml extends Block_Display {
 	var $_customer;
 	function init() {
 		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		if($this->_customer instanceof Model_Customer && $this->_customer->get('id')) {
 			$this->fetch('customer', 'view/xml');
 		}
 		return $this;
 	}
 }