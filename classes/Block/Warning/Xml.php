<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Warning_Xml extends Block_Display {
 	var $_items;
 	var $_customer;
 	function init() {
 		$this->_blockname = 'warning';
 		$this->_items = $this->_core->getModel('Warning/Collection')->getCollection();
 		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		$this->fetch('warning', 'xml');
 		return $this;
 	}
 }