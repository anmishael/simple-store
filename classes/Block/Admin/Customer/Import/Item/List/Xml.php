<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 29.03.13
 * Time: 10:53
 * To change this template use File | Settings | File Templates.
 */
class Block_Admin_Customer_Import_Item_List_Xml extends Block_Display {
	function init() {
		if($this->_core->getRequest('iid')) {
			$this->_items = $this->_core->getModel('Import/Item/Collection')->newInstance()
				->addFilter('import_id', $this->_core->getRequest('iid'), 'eq')
				->getCollection();
			$this->fetch('customer', 'import/item/list/xml');
		}
		return $this;
	}
}
