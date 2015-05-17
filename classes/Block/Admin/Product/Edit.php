<?php
/*
 * Created on 13 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
 
 class Block_Admin_Product_Edit extends Block_Display {
 	var $_types;
 	var $_actions;
 	var $_customer;
 	var $_languages;
 	var $_description;
 	var $_pages;
 	function init() {
 		$this->_languages = $this->_core->getModel('Language/Collection')->getCollection('id');
 		if($this->_core->getRequest('doctype') == 'ajax') {
 			if(method_exists($this, $this->_core->getRequest('action'))) {
 				$action = $this->_core->getRequest('action');
 				$this->$action();
 			}
 		} else {
	 		$this->_item = $this->_core->getModel('Product/Collection')
	 			->clear()
	 			->addFilter('id', $this->_core->getRequest('id'), 'eq')
	 			->getOne();
// 	 		$this->_item = $this->_item[0];
	 		if(!is_object($this->_item) || !$this->_item->get('id')) {
	 			$this->_item = new Model_Product();
	 		} else {
	 			$this->_item->fetchDescription();
	 		}
	 		
	 		$this->_customer = $this->_core->getModel('Customer/Collection')->newInstance()
	 				->addFilter('id', $this->_item->get('cid'), 'eq')
	 				->getOne();
	 		if(!$this->_customer instanceof Model_Customer || !$this->_customer->get('id')) {
	 			$this->_customer = false;
	 		}
	 		$this->_actions = array('images'=>array(), 'videos'=>array(), 'items'=>array(), 'image_area');
	 		$this->_item->fetchImages();
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImageEdit')) {
	 			$this->_actions['images'][] = array(
	 				'url'=>$this->_core->getActionUrl('admin-product-image-edit'),
	 				'name'=>'edit'
	 			);
	 		}
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImageRemove')) {
	 			$this->_actions['images'][] = array(
	 				'url'=>$this->_core->getActionUrl('admin-product-image-remove'),
	 				'name'=>'remove'
	 			);
	 		}
			 if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImageRemove')) {
				 $this->_actions['images'][] = array(
					 'url'=>$this->_core->getActionUrl('admin-product-image-remove'),
					 'name'=>'remove'
				 );
			 }
			 if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImageClearThumbnail')) {
				 $this->_actions['image_area'][] = array(
					 'url'=>$this->_core->getActionUrl('admin-product-image-clear-thumbnail'),
					 'name'=>'clear thumbnails'
				 );
			 }
	 		$this->_item->fetchVideos();
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'VideoEdit')) {
	 			$this->_actions['videos'][] = array(
	 				'url'=>$this->_core->getActionUrl('admin-product-video-edit'),
	 				'name'=>'edit'
	 			);
	 		}
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'VideoRemove')) {
	 			$this->_actions['videos'][] = array(
	 				'url'=>$this->_core->getActionUrl('admin-product-video-remove'),
	 				'name'=>'remove'
	 			);
	 		}
	 		
	 		$this->_item->fetchFilters();
	 		$this->_item->fetchPages();
	 		
	 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ItemRemove')) {
		 		$this->_actions['items'][] = array(
		 				'url'=>$this->_core->getActionUrl('admin-product-item-remove'),
		 				'name'=>'remove',
		 				'warning'=>'Are you sure you wish to remove "%s" product item?'
		 			);
	 		}
	 		
	 		$this->_filter_types = array();
	 		$ft = $this->_core->getModel('Filter/Type/Collection')->newInstance()->getCollection(false, true, true);
	 		foreach($ft as $k=>$v) {
	 			$this->_filter_types[$v->get('id')] = $v;
	 			unset($ft[$k]);
	 		}
	 		unset($ft);
	 		$this->_pages = $this->_core->getModel('Page/Collection')->newInstance()->getCollection(false, true, true);
	 		$this->_types = $this->_core->getModel('Product/Type/Collection')->newInstance()->getCollection();
	 		$this->fetch('product', 'edit');
	 		$this->fetchjs('product', 'edit');
 		}
 		return $this;
 	}
 	function getCities() {
 		if($this->_core->getRequest('state')) {
 			$state = $this->_core->getModel('State/Collection')->newInstance()
 					->addFilter('id', (int)$this->_core->getRequest('state'), 'eq')
 					->getCollection();
 			if(isset($state[0]) && $state[0] instanceof Model_State) {
 				$this->_state = $state[0];
 				$this->_cities = $this->_state->fillCities()->get('cities');
 			}
 		}
 		$this->fetch('product', 'ajax/cities');
 	}
 }