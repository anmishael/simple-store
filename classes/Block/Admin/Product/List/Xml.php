<?php
/**
 * Xml.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 20.02.13
 * Time: 13:05
 */
class Block_Admin_Product_List_Xml extends Block_Display {
	var $_items;
	function init() {
		$coll = $this->_core->getModel('Product/Collection')->newInstance()
			->setOrder('name')
			->setOrderWay('ASC');
		if(strlen(trim($this->_core->getRequest('search')))>0) {
			$words = explode(' ', str_replace('  ', ' ', trim($this->_core->getRequest('search'))));
			foreach($words as $word) {
				$coll->addGroupFilter('search', 'name', $word, 'like')
					->addGroupFilter('search', 'code', $word, 'like')
					->addGroupFilter('search', 'sku', $word, 'like');
			}
		}
		$this->_items = $coll->getCollection(false, true, true);
		$this->fetch('product', 'list/xml');
	}
}
