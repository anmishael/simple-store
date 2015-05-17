<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 23.03.13
 * Time: 18:55
 * To change this template use File | Settings | File Templates.
 */

class Block_Admin_Product_Import_Item_List_Xml extends Block_Display {
	var $_items;
	function init() {
		if($this->_core->getRequest('iid')) {
			$this->_items = $this->_core->getModel('Import/Item/Collection')->newInstance()
				->addFilter('import_id', $this->_core->getRequest('iid'), 'eq')
				->getCollection();
			$this->fetch('product', 'import/item/list/xml');
		}
		return $this;
	}
}