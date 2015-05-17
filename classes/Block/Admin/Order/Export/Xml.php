<?php
/**
 * Xml.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 19.11.12
 * Time: 9:16
 *
 * @property Model_Order $_item
 */

class Block_Admin_Order_Export_Xml extends Block_Display {
	var $_item;
	function init() {
		if($this->_core->getRequest('id')) {
			$this->_item = $this->_core->getModel('Order/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();

			if($this->_item instanceof Model_Object) {
				$this->_item->fetchProducts();
				$res = $this->apply('order', 'export/xml');
				$file = $this->_core->getModel('File')->newInstance()
					->setContent($res)
					->setType('text/xml')
					->display();
				die();
			}
		}
	}
}
