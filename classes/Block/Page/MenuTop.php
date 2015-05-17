<?php
/**
 * File: MenuTop.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

 class Block_Page_MenuTop extends Block_Display {
 	var $_items = array();
 	function init() {
 		$this->_blockname = 'menutop';
 		$arrUrl = explode('/', $this->_core->getUrl());
		if(!$this->_core->notNull(trim($arrUrl[0]))) {
			array_shift($arrUrl);
		}
 		$menu = $this->_core->getModel('Page/Menu/Collection')
 				->clear()
 				->addFilter('name', 'menutop', 'eq')
 				->getCollection();
 		$menu = $menu[0];
 		$this->_items = $menu->getPages(0);
 		foreach ( $this->_items as $key => $value ) {
 			$this->_items[$key]->push($menu->get('id'));
			$this->_items[$key]->fetchChildren();
		}
//		die('<pre>'.print_r($this->_items,1).'</pre>');
 		$this->fetch('page', 'menutop');
 		return $this;
 	}
 	function generateTree($pages, $deep = 0) {
 		$res = '';
		$i=0;
 		foreach($pages as $page) {
			 if($deep==0 && $i%3 == 0) {
				 $res .= '</ul><ul class="submenu">';
			 }
 			$res .= '<li class="deep-'.$deep.' item-'.$i.'"><a class="title link-' . $deep . '" href="'.$page->get('url').'">'.$page->get('menutitle').'</a>';
 			if($page->get('children')) {
 				$res .= '<ul class="deep-'.$deep.'">
			'.$this->generateTree($page->get('children'),$deep+1).'
			</ul>';
 			}
 			$res .= '</li>';
			 $i++;
 		}
 		return $res;
 	}
 }