<?php
/**
 * Created on 20 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Product_view_Xml extends Block_Display {
 	var $_item;
 	var $_items;
 	var $_places;
 	var $_customer;
 	function init() {
 		$this->_item = $this->_core->getModel('Product/Collection')->newInstance()
 				->addFilter('p.id', $this->_core->getRequest('id'), 'eq')
 				->getCollection();
 		if(isset($this->_item[0]) && $this->_item[0] instanceof Model_Product) {
 			$this->_item = $this->_item[0];
 			$this->_item->push('reward', ($this->_item->get('price_max')>0 ? ceil(($this->_item->get('price_max')+$this->_item->get('price_min'))/4) : ceil($this->_item->get('price_min')/4) ));
 		} else {
 			$this->_item = new Model_Product();
 		}
 		$this->_item->fetchImages()->fetchVideos()->fetchItems()->fetchPlaces();
// 		$this->_places = $this->_core->getModel('Place/Collection')->newInstance()->getCollection('code');
 		
 		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		/*
 		$arr = array();
 		if($this->_customer instanceof Model_Customer && $this->_customer->get('id')) {
 			$this->_favorites = $this->_core->getModel('Product/Collection')->newInstance()
 				->addTable('product_favorites', 'pf')
 				->addFilter('pf.cid', $this->_customer->get('id'), 'eq')
 				->addFilter('p.id', 'pf.pid', 'eq', false)
 				->getCollection('id');
 		} else {
 			$this->_favorites = $_SESSION['favorites'];
 		}
 		//*/
 		$this->fetch('product', 'view/xml');
 	}
 }