<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Breadcrumb_List extends Block_Display {
	var $_items;
	var $_page;
	function init() {
		$plist = $this->_core->getModel('Page/History/Collection')->getCollection();
		if(isset($plist[0])) {
			$page = $this->_core->getModel('Page/Collection')->newInstance()->addFilter('id', $plist[0]['id'], 'eq')->getOne(false,true,true);
			if($page instanceof Model_Page) {
				$this->_page = $page;
				if($this->getParam('product') && $this->getParam('product') instanceof Model_Product) {
					$pages = $this->getParam('product')->fetchPages('id', 'parent DESC')->get('pages');
					if($pages[$page->get('id')] instanceof Model_Page) {
						$this->_items = array_reverse($pages[$page->get('id')]->fetchParents()->get('parents'));
						$this->_items[] = $page;
					}
				} else {
					$this->_items = array_reverse($page->fetchParents()->get('parents'));
					$this->_items[] = $page;
				}
			}
		} else {
			if($this->getParam('product')) {
				$pages = $this->getParam('product')->fetchPages(false, 'parent DESC')->get('pages');
				if($pages[0] instanceof Model_Page) {
					$this->_page = $pages[0];
					$this->_items = array_reverse($pages[0]->fetchParents()->get('parents'));
					$this->_items[] = $pages[0];
				}
			}
		}
		$this->fetch('breadcrumb', 'list');
		return $this;
	}
}