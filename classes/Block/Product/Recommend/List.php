<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Block_Product_Recommend_List extends Block_Display {
	var $_items;
	var $_limit = 4;
	function init() {
		if($this->_core->getBlock('Breadcrumb/List')->_page instanceof Model_Page) {
			$this->_items = $this->_core->getBlock('Breadcrumb/List')->_page->fetchProducts($this->_limit, false, false, true, ($this->_core->getBlock('Product/View')->_item instanceof Model_Product?array($this->_core->getBlock('Product/View')->_item->get('id')):array()))->get('products');
			$this->fetch('product', 'recommend/list');
		}
		return $this;
	}
}