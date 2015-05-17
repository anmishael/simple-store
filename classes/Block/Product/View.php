<?php
/*
 * Created on May 18, 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Product_View extends Block_Display {
	var $_item;
	var $_items;
	var $_places;
	var $_customer;
	var $_filters;
	var $_filter_types;
	var $_reviews;
	function init() {
		$this->_item = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('products.id', $this->_core->getRequest('id'), 'eq')
			->addFilter('status', 0, 'neq');
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$this->_item->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		$this->_item = $this->_item->getOne(false, true, true);
		if($this->_item instanceof Model_Product) {
			$this->_core->getBlock('Display')->newInstance()->push('_blockname', 'title')->addOutput(trim(str_replace("\n", ' ', htmlspecialchars($this->_item->get('name') . ', ' . $this->_item->get('sku')))));
			$this->_core->getBlock('Display')->newInstance()->push('_blockname', 'metakeys')->addOutput(trim(str_replace("\n", ' ', $this->_item->get('metakey')?$this->_item->get('metakey'):str_replace(' ', ',', htmlspecialchars($this->_item->get('name'))))));
			$this->_core->getBlock('Display')->newInstance()->push('_blockname', 'metadescription')->addOutput(trim(str_replace("\n", ' ', $this->_item->get('metadescription')?$this->_item->get('metadescription'):htmlspecialchars($this->_item->get('name')))));

			$this->_item->fetchImages()->fetchVideos()->fetchReviews();//->fetchItems()->fetchPlaces();
//  		$this->_places = $this->_core->getModel('Place/Collection')->newInstance()->getCollection('code');

			$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
			$arr = array();
			if($this->_customer instanceof Model_Customer && $this->_customer->get('id')) {
				$this->_favorites = $this->_core->getModel('Product/Collection')->newInstance()
					->addTable('product_favorites', 'pf')
					->addFilter('pf.cid', $this->_customer->get('id'), 'eq')
					->addFilter('products.id', 'pf.pid', 'eq', false)
					->getCollection('id');
			} else {
				$this->_favorites = $_SESSION['favorites'];
			}
//			$this->_core->setDebug(1);
			$this->_item->fetchFilters(true);
//			$this->_core->setDebug(0);
			$this->_filters = $this->_item->get('filters');
// 		print_r($this->_filters);
			foreach($this->_filters as $k=>$v) {
				if(!is_array($this->_filter_types[$v->get('filter_type_url')])) {
					$this->_filter_types[$v->get('filter_type_url')] = array('name'=>$v->get('filter_type_name'), 'filters'=>array());
				}
				$this->_filter_types[$v->get('filter_type_url')]['filters'][] = $k;
			}
// 		print_r($this->_filters);
// 		die(print_r($this->_favorites,1));
//		print_r($this->_item);

			if($this->_core->getRequestSess('last_post')) {
				$this->_post = $this->_core->getRequestSess('last_post');
				unset($_SESSION['last_post']);
			}

			$this->_core->getBlock('Product/Popular/Box')->init();
			$this->_core->getBlock('Breadcrumb/List')->init();

			$this->fetch('product', 'view');
			$this->fetchjs('product', 'view');

			$this->_core->getBlock('Product/Similar/List')->init();
			$this->_core->getBlock('Product/Recommend/List')->init();
		} else {
			$this->_item = $this->_core->getModel('Product')->newInstance();
		}


//  		$this->fetchjs('customer', 'offer');
		return $this;
	}
}