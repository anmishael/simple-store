<?php
/**
 * Created on 26 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 * @property Model_Page_Collection[] $_items
 * @property Model_Page $_page
 * @property Model_Page_Collection[] $_parents
 */


class Block_Page_Category_Box extends Block_Display {
	var $_items;
	var $_children;
	var $_page;
	var $_parents = array();
	function init() {
		$this->_blockname = 'contentleft';
		$this->_page = $this->_core->getModel('Page/Collection')->getCurrentPage();
		if($this->_page instanceof Model_Page) {
			/*
			$a = array();
			$this->_parents = $this->_page->getParents(null, null, 'id');
			$this->_items = $this->_core->getModel('Page/Collection')->newInstance()
					->addTable('products_to_pages', 'p2p')
					->addFilter('parent', 0, 'eq')
					->addFilter('prid_pgid', 'pgid=id', 'logic')
					->setGroup('pgid')
					->getCollection(false,true,true);
			//*/
			$this->_items = $this->_core->getModel('Page/Collection')->newInstance()
				->addFilter('parent', 0, 'eq')
				->addFilter('category', 1, 'eq')
				->setOrder('`pages_description`.name')
				->setOrderWay('ASC')
				->getCollection(false, true, true);
			foreach($this->_items as $k=>$item) {
				$this->_items[$k]->getChildren(null, true);
			}
//			die(print_r($this->_parents, 1));
			$this->fetch('page', 'category/box');
		}
		return $this;
	}
	function displayChildren($page, $res) {
		$items = $page->get('children');
		$res = '<ul class="subtree" id="tree-'.$page->get('id').'">';
		foreach($items as $k=>$item) {
			$res .= '<li id="categoryrow-'.$item->get('id').'">' . (sizeof($item->get('children'))>0?'<a class="plus closed" href="javascript:;" rel="' . $item->get('id') . '"><span class="icon"></span></a> ':'<span>&mdash;</span> ').'<a href="'.$item->get('url').'">'.$item->get('name').'</a>';
//			if($this->_parents[$item->get('id')] || $item->get('id') == $this->_page->get('id')) $res .= $this->displayChildren($item);
			if($item->get('children')) {
				$res .= $this->displayChildren($item);
			}
			$res .= '</li>';
		}
		$res .= '</ul>';
		return $res;
	}
}