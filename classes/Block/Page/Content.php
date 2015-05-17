<?php
/**
 * File: Content.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

/**
 * @property Model_Page $_page
 */
class Block_Page_Content extends Block_Display {
	var $_page;
	var $_items;
	var $_url;
	var $_total = 0;
	var $_current_page = 1;
	var $_result_perpage = 32;
	var $_limit_start;
	var $_view = 'grid';
	var $_filter_types;
	var $_rowlength = 4;
	var $_sortby;
	var $_defaultsort;
	var $show_filters = false;
	var $_display_price = false;
	function init() {
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) {
			$this->_display_price = true;
		}
		$this->_sortby = array(
			'name'=>array(
				'order'=>'`products_description`.name',
				'way'=>'ASC',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_NAME')->get('value')
			),
			'price'=>array(
				'order'=>'`products`.price',
				'way'=>'ASC',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_PRICE')->get('value')
			)
		);
		$rowlength = $this->_rowlength;
		$result_perpage = $this->_result_perpage;

		if($this->_core->notNull($this->_core->getRequestGet('limit'))) {
			if($this->_core->getRequestGet('limit')>0) {
				$result_perpage = $this->_core->getRequestGet('limit');
			} else {
				$result_perpage = 0;
			}
		}
// 		if(strlen(trim($this->_core->getModel('Page/Collection')->getCurrentPage()->get('content_left')))<=0) {
//		 	$rowlength = 5;
//		 	$result_perpage = 10;
//		}
//		unset($_SESSION['defaultsort']);
		if($this->_core->getRequest('sort') && isset($this->_sortby[$this->_core->getRequest('sort')])) {
			$_SESSION['defaultsort'] = $this->_core->getRequest('sort');
			$this->_defaultsort = $_SESSION['defaultsort'];
		} elseif($_SESSION['defaultsort']) {
			$this->_defaultsort = $_SESSION['defaultsort'];
		} else {
			$this->_defaultsort = 'name';
			$_SESSION['defaultsort'] = $this->_defaultsort;
		}

		if($this->_core->getRequest('view') && in_array($this->_core->getRequest('view'), array('grid', 'list', 'window'))) {
			$this->_view = $this->_core->getRequest('view');
			$_SESSION['view'] = $this->_view;
		} elseif($_SESSION['view']) {
			$this->_view = $_SESSION['view'];
		}
		$this->_filter_types = $this->_core->getModel('Filter/Type/Collection')->newInstance()->getCollection('id',true,true);
		/*$this->_brands = $this->_core->getModel('Filter/Collection')->newInstance()
				 ->addFilter('ft.url', 'brand', 'eq')
				 ->addTable('filter_types', 'ft', array('ft.id as ftid', 'ft.name as ftname', 'ft.url as fturl'))
				 ->addFilter('type', 'ft.id=`filters`.type', 'logic')
				 ->getCollection('id');
		 //*/
		$this->_page = $this->_core->getModel('Page/Collection')->getCurrentPage();
		if($this->_page instanceof Model_Page) {
			$this->_core->getBlock('Display')->newInstance()->push('_blockname', 'metakeys')->addOutput(trim(str_replace("\n", ' ', $this->_core->notNull($this->_page->get('metakey'))>0?$this->_page->get('metakey'):str_replace(' ', ',', $this->_page->get('menutitle')))));
			$this->_core->getBlock('Display')->newInstance()->push('_blockname', 'metadescription')->addOutput(trim(str_replace("\n", ' ', $this->_core->notNull($this->_page->get('metadescription'))?$this->_page->get('metadescription'):$this->_page->get('menutitle'))));
			$this->_url = $this->_page->get('url');
			$this->_page->fetchDescription($this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'));
			$this->_current_page = (int)$this->_core->getRequestGet('_p')>0 ? (int)$this->_core->getRequestGet('_p') : 1;
			$this->_limit_start = ( $this->_current_page*$result_perpage-$result_perpage);

//			$this->_core->setDebug(2);
			$this->_page->fetchProducts(
				($result_perpage>0?$this->_limit_start . ', ' . $result_perpage:''),
				$this->_core->getRequest('filter'),
				$this->_sortby[$this->_defaultsort],
				false,
				array(),
				1,
				$this->_core->getRequest('price-max')>0?array('min'=>$this->_core->getRequest('price-min'), 'max'=>$this->_core->getRequest('price-max')*1.15):null
			);

// 			$this->_core->setDebug(0);
//			print_r(sizeof($this->_page->get('products')));
			$this->_max_price = $this->_page->get('max_price');
//			die($this->_max_price);
			$this->fetch('page', 'content');
//			$this->_core->setDebug(2);
			$total = $this->_page->getProductsTotal(
				false,
				1,
				null,
				false,
				$this->_core->getRequest('price-max')>0?array('min'=>$this->_core->getRequest('price-min'), 'max'=>$this->_core->getRequest('price-max')*1.15):null
			);
//			echo $total;
			//$this->_core->setDebug(10);
			if($total==0) {
				$pg = clone($this->_page);
				$pg->fetchProducts(
					($result_perpage>0?$this->_limit_start . ', ' . $result_perpage:''),
					false,
					$this->_sortby[$this->_defaultsort],
					false,
					array(),
					1,
					$this->_core->getRequest('price-max')>0?array('min'=>$this->_core->getRequest('price-min'), 'max'=>$this->_core->getRequest('price-max')*1.15):null
				);
				if(sizeof($pg->get('products'))>0) {
					$this->_no_products = true;
				}
			}
			
			//$this->_core->setDebug(0);
			if($total>0 || $this->_no_products) {
				$this->setParam('rowlength', $rowlength);
				$this->_items = $this->_page->get('products');
//				$this->_total = $this->_page->getProductsTotal($this->_core->getRequest('filter'), 1);
				$this->_total = $total;
				$this->_totalpages = ceil($this->_total/$result_perpage);
				if(!$this->_items) $this->_items = array();
//				$this->_core->setDebug(1);
				if($this->_core->getBlock('Product/Filter/Box')->init()->_display) {
					$this->setParam('rowlength', $this->_rowlength);
					$this->_totalpages = ceil($this->_total/$result_perpage);
				}
//				$this->_core->setDebug(0);
				$this->show_filters = true;
//				$this->fetch('product', $this->_view);
				$this->fetch('product', 'list');
			} elseif($this->_page->getProductsTotal(false, 1, null, false)) {
				$this->_core->getBlock('Product/Filter/Box')->init();
				$this->show_filters = true;
				$this->fetch('product', 'list');
			}
//			$this->_core->setDebug(0);
			/*
			 if($this->_page->getProductsTotal(false, 1)>0) {
				 $this->_core->getBlock('Page/Category/Box')->init();
				 $this->setParam('rowlength', $rowlength);
				 $this->_items = $this->_page->get('products');
				 $this->_total = $this->_page->getProductsTotal($this->_core->getRequest('filter'));
				 $this->_totalpages = ceil($this->_total/$result_perpage);
				 if(!$this->_items) $this->_items = array();
				 if($this->_core->getBlock('Product/Filter/Box')->init()->_display) {
					 $this->setParam('rowlength', $this->_rowlength);
					 $this->_totalpages = ceil($this->_total/$result_perpage);
				 }
				 $this->fetch('product', $this->_view);
			 }//*/
		}
		return $this;
	}
}