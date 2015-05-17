<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_Page_Edit extends Block_Display {
 	var $_item;
 	var $_menus;
 	var $_inmenus;
 	var $_sortorder;
 	var $_images;
 	var $_languages;
 	var $_description;
 	var $_pages;
 	function init() {
 		$this->_languages = $this->_core->getModel('Language/Collection')->getCollection('id');
//  		$this->_core->getResource('DB')->getConnection()->debug=1;
 		$this->_item = $this->_core->getModel('Page/Collection')
 			->clear()
 			->addFilter('id', $this->_core->getRequest('id'), 'eq')
 			->getOne(false, true, $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'));
 		if(!is_object($this->_item)) {
 			$this->_item = new Model_Page();
 		} else {
 			$this->_item->fetchDescription();
 		}
 		
 		$this->_pages = $this->_core->getModel('Page/Collection')->newInstance()
 				->addFilter('id', $this->_item->get('id'), 'neq')
 				->getCollection(false, true, $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'));
 		
 		$this->_inmenus = $this->_item->getMenus();
 		$this->_sortorder = array();
 		foreach($this->_inmenus as $k=>$v) {
 			$this->_inmenus[$k] = $v->get('id');
 			$this->_sortorder[$v->get('id')] = $v->get('sortorder');
 		}
 		$this->_menus = $this->_core->getModel('Page/Menu/Collection')
 			->clear()
 			->getCollection();
 		if($this->_item instanceof Model_Page && $this->_item->get('id')) {
 			$this->_images = $this->_core->listFolder($this->_core->getSingleton('Config')->getPath() . 'images' . $this->_core->getSystemSlash() . 'pages' . $this->_core->getSystemSlash() . $this->_item->get('id'));
 			$this->_core->getModel('Image');
 			foreach($this->_images as $k=>$v) {
 				$this->_images[$k] = $this->_core->fixFolderSlash(str_replace($this->_core->getSingleton('Config')->getPath(), '', $v));
 				
 				$this->_images[$k] = new Model_Image(
 							array(
								'path'=>$v,
								'url'=>$this->_images[$k]
							)
 						);
 			}
 		}
 		$this->fetch('page', 'edit', $searchForBlock = false);
 		return $this;
 	}
 }