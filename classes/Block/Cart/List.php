<?php
/**
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Cart_List extends Block_Display {
 	var $_items;
 	var $_cart;
 	var $_currency;
 	function init() {
 		$this->_items = $this->_core->getModel('Cart/Collection')->getCollection();
 		$this->_cart = $this->_core->getModel('Cart');
 		$this->_currency = $this->_core->getModel('Currency/Collection')->fetch();
 		$this->fetch('cart', 'list');
 		return $this;
 	}
 }