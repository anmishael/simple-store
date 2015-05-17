<?php
/*
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

class Block_Admin_Product_List extends Block_Display {
	var $_items = array();
	var $_actions = array();
	var $_toplinks = array();
	var $_pages;
	var $_limit = 100;
	var $_arrLimit = array(10, 20, 50, 100, 500, 1000);
	var $_way = array('asc','desc');
	var $_sortway = 'asc';
	function init() {
		$this->_sortby = array(
			'id'=>array(
				'order'=>'id',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_ID')->get('value')
			),
			'name'=>array(
				'order'=>'name',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_NAME')->get('value')
			),
			'price'=>array(
				'order'=>'`products`.price',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_PRICE')->get('value')
			),
			'code'=>array(
				'order'=>'`products`.code',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_CODE')->get('value')
			),
			'qty'=>array(
				'order'=>'`products`.quantity',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_CODE')->get('value')
			),
			'added'=>array(
				'order'=>'`products`.added',
				'title'=>$this->_core->getModel('Translate/Collection')->get('PRODUCT_LIST_SORT_ADDED')->get('value')
			),
			'additional'=>array(
				'order'=>'`products`.additional',
				'title'=>$this->_core->getModel('Translate/Collection')->get('Додатково')->get('value')
			),
			'status'=>array(
				'order'=>'`products`.status',
				'title'=>$this->_core->getModel('Translate/Collection')->get('Додатково')->get('value')
			),
			'status_new'=>array(
				'order'=>'`products`.status_new',
				'title'=>$this->_core->getModel('Translate/Collection')->get('Додатково')->get('value')
			),
			'status_action'=>array(
				'order'=>'`products`.status_action',
				'title'=>$this->_core->getModel('Translate/Collection')->get('Додатково')->get('value')
			),
			'status_topsell'=>array(
				'order'=>'`products`.status_topsell',
				'title'=>$this->_core->getModel('Translate/Collection')->get('Додатково')->get('value')
			)
		);
		if($this->_core->getRequest('sort') && isset($this->_sortby[$this->_core->getRequest('sort')])) {
			$_SESSION['defaultsort'] = $this->_core->getRequest('sort');
			$this->_defaultsort = $_SESSION['defaultsort'];
		} elseif($_SESSION['defaultsort']) {
			$this->_defaultsort = $_SESSION['defaultsort'];
		} else {
			$this->_defaultsort = 'name';
			$_SESSION['defaultsort'] = $this->_defaultsort;
		}
		if($this->_core->getRequest('way') && in_array($this->_core->getRequest('way'), $this->_way)) {
			$_SESSION['defaultsortway'] = $this->_core->getRequest('way');
			$this->_sortway = $_SESSION['defaultsortway'];
		} elseif($_SESSION['defaultsortway']) {
			$this->_sortway = $_SESSION['defaultsortway'];
		} else {
			$this->_sortway = 'asc';
			$_SESSION['defaultsortway'] = $this->_sortway;
		}

		$search = str_replace(' ', ',', $this->_core->getRequest('search'));
		$search = str_replace('  ', ' ', $this->_core->getRequest('search'));
		$arr_s = explode(' ', $search);
		$this->_pages = $this->_core->getModel('Page/Collection')->newInstance()->getCollection(false, true, true);
		$this->_items = $this->_core->getModel('Product/Collection')
			->newInstance()
			->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit);
		if(sizeof($arr_s)>0) {
			$this->_items->addGroupFilter('search', '`code`', $arr_s, 'like');
			$this->_items->addGroupFilter('search', '`name`', $arr_s, 'like');
// 			$this->_items->addFilter('`code`', $arr_s, 'like');
		}
// 		$this->_core->setDebug(1);
		$this->_items = $this->_items
			->setOrder($this->_sortby[$this->_defaultsort]['order'])
			->setOrderWay($this->_sortway)
			->getCollection(false, true, $this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id'));
// 		$this->_core->setDebug(0);
		$this->_totalpages = $this->_core->getModel('Product/Collection')->newInstance();
		if(sizeof($arr_s)>0) {
//			$this->_totalpages->addGroupFilter('search', '`code`', $arr_s, 'like');
// 			$this->_totalpages->addGroupFilter('search', '`name`', $arr_s, 'like');
//			$this->_totalpages->addFilter('`code`', $arr_s, 'like');
		}
		$this->_totalpages = ceil($this->_totalpages->getTotal()/$this->_limit);

		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'Edit')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRODUCT', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'Import')) {
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-import'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_PRODUCT', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'Remove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Are you sure you wish to remove "%s" product?'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'BundleList')) {
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-bundle-list'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRODUCT_BUNDLE_LIST', 'value')->get('value')//,
//				'warning'=>'Are you sure you wish to remove "%s" product?'
			);
		}

		$this->_filter_types = array();
		$ft = $this->_core->getModel('Filter/Type/Collection')->newInstance()->getCollection();
		foreach($ft as $k=>$v) {
			/** @var $v Model_Filter_Type */
			$v->getFilters();
			$this->_filter_types[$v->get('id')] = $v;
			unset($ft[$k]);
		}

		$this->fetchjs('product', 'list');
		$this->fetch('product', 'list');
		return $this;
	}
}
 
