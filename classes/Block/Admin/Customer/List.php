<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Block_Admin_Customer_List extends Block_Display {
	var $_items = array();
	var $_actions = array();
	var $_toplinks = array();
	var $_arrtypes = array();
	var $_types = array();
	var $_limit = 100;
	var $_arrLimit = array(10, 20, 50, 100, 500, 1000);
	var $_way = array('asc','desc');
	var $_sortway = 'asc';
	function init() {
		$this->_sortby = array(
			'id'=>array(
				'order'=>'id'
			),
			'name_first'=>array(
				'order'=>'name_first'
			),
			'name_last'=>array(
				'order'=>'name_last'
			),
			'address1'=>array(
				'order'=>'address1'
			),
			'address2'=>array(
				'order'=>'address2'
			),
			'phone'=>array(
				'order'=>'phone'
			),
			'email'=>array(
				'order'=>'email'
			),
			'pricegroup'=>array(
				'order'=>'pricegroup'
			),
			'typeid'=>array(
				'order'=>'typeid'
			),
			'status'=>array(
				'order'=>'status'
			)
		);
		if($this->_core->getRequest('sort') && isset($this->_sortby[$this->_core->getRequest('sort')])) {
			$_SESSION['defaultsort'] = $this->_core->getRequest('sort');
			$this->_defaultsort = $_SESSION['defaultsort'];
		} elseif($_SESSION['defaultsort']) {
			$this->_defaultsort = $_SESSION['defaultsort'];
		} else {
			$this->_defaultsort = 'id';
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
		$this->_types = $this->_core->getModel('Customer/Type/Collection')->getCollection();
		foreach($this->_types as $k=>$v) {
			$this->_arrtypes[$v->get('id')] = $v->toArray();
		}
		$this->_prices = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()->getCollection('id');

		$coll = $this->_core->getModel('Customer/Collection')->newInstance()
			->setOrder($this->_sortby[$this->_defaultsort]['order'])
			->setOrderWay($this->_sortway);

		$search = str_replace(' ', ',', $this->_core->getRequest('search'));
		$search = str_replace('  ', ' ', $this->_core->getRequest('search'));
		$arr_s = explode(' ', $search);
		if(sizeof($arr_s)>0) {
			$coll->addGroupFilter('search', '`name_first`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`name_last`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`cardcode`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`phone`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`email`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`address1`', $arr_s, 'like');
			$coll->addGroupFilter('search', '`address2`', $arr_s, 'like');
		}

		$this->_totalpages = clone($coll);

		$this->_totalpages = ceil($this->_totalpages->getTotal()/$this->_limit);

		$this->_items = $coll->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit)->getCollection();

		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'Edit')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_CUSTOMER', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'Remove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Are you sure you wish to remove "%s" customer?'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'Import')) {
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-import'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_IMPORT_CUSTOMER', 'value')->get('value')
			);
		}
		$this->fetch('customer', 'list');
		return $this;
	}
}