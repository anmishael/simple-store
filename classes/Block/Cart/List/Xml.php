<?php
/**
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Cart_List_Xml extends Block_Display {
	var $_items;
	function init() {
		$this->_items = $this->_core->getModel('Cart/Collection')->getCollection();
		$this->_total = $this->_core->getModel('Cart')->subtotalsumm();
		$this->_currency = $this->_core->getModel('Currency/Collection')->fetch()->get('label');
		$this->fetch('cart', 'list/xml');
		return $this;
	}
}