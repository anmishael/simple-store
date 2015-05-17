<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Cart_Box extends Block_Display {
	var $_cart;
	var $_currency;
	function init() {
		$this->_blockname = 'cartbox';
		$this->_cart = $this->_core->getModel('Cart');
		$this->_currency = $this->_core->getModel('Currency/Collection')->fetch();
		$this->fetch('cart', 'box');
		return $this;
	}
}