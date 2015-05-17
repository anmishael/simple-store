<?php
/*
 * Created on May 22, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Page_Footer extends Block_Display {
 	var $_items;
 	function init() {
 		$this->_blockname = 'footer';
 		$menu = $this->_core->getModel('Page/Menu/Collection')
 				->clear()
 				->addFilter('name', 'menubottom', 'eq')
 				->getOne();
 		if($menu instanceof Model_Page_Menu) {
 			$this->_items = $menu->getPages();
 		}
 		$this->fetch('page', 'footer');
 		return $this;
 	}
 }