<?php
/**
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Cart_View extends Block_Display {
	var $_items;
	var $_cart;
	function init() {
		$this->_items = $this->_core->getModel('Cart/Collection')->getCollection();
		$this->_cart = $this->_core->getModel('Cart');
		$this->fetch('cart', 'view');
		return $this;
	}
}