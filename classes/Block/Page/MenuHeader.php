<?php
/**
 * Created on 7 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */

class Block_Page_MenuHeader extends Block_Display {
	var $_items;
	var $_customer;
	function init() {
		$this->_blockname = 'menuheader';
		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
		$arrUrl = explode('/', $this->_core->getUrl());
		if(!$this->_core->notNull(trim($arrUrl[0]))) {
			array_shift($arrUrl);
		}
		$menu = $this->_core->getModel('Page/Menu/Collection')
		->clear()
		->addFilter('name', 'menuheader', 'eq')
		->getOne();
		$this->_items = $menu->getPages();
// 		print_r($this->_items);
		$this->fetch('page', 'menuheader');
		return $this;
	}
}