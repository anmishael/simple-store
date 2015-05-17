<?php
/**
 * Created on 23 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Admin_Order_List extends Block_Display {
	var $_items = array();
	var $_actions = array();
	var $_toplinks = array();
	var $_statuses;
	var $_limit = 10;
	var $_arrLimit = array(10, 20, 50, 100, 500, 1000);
	var $_way = array('asc','desc');
	function init() {
		$this->_sortby = array(
			'id'=>array(
				'order'=>'id',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID')->get('value')
			),
			'created'=>array(
				'order'=>'created',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CREATED')->get('value')
			),
			'billname_first'=>array(
				'order'=>'billname_first',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST')->get('value')
			),
			'billname_last'=>array(
				'order'=>'billname_last',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST')->get('value')
			),
			'email'=>array(
				'order'=>'email',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL')->get('value')
			),
			'total'=>array(
				'order'=>'total',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TOTAL')->get('value')
			),
			'status'=>array(
				'order'=>'status',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS')->get('value')
			),
			'shipping_method'=>array(
				'order'=>'shipping_method',
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SHIPPING')->get('value')
			)
		);
		if($this->_core->getRequest('sort') && isset($this->_sortby[$this->_core->getRequest('sort')])) {
			$_SESSION['defaultsort'] = $this->_core->getRequest('sort');
			$this->_defaultsort = $_SESSION['defaultsort'];
		} elseif($_SESSION['defaultsort']) {
			$this->_defaultsort = $_SESSION['defaultsort'];
		} else {
			$this->_defaultsort = 'created';
			$_SESSION['defaultsort'] = $this->_defaultsort;
		}
		if($this->_core->getRequest('way') && in_array($this->_core->getRequest('way'), $this->_way)) {
			$_SESSION['defaultsortway'] = $this->_core->getRequest('way');
			$this->_sortway = $_SESSION['defaultsortway'];
		} elseif($_SESSION['defaultsortway']) {
			$this->_sortway = $_SESSION['defaultsortway'];
		} else {
			$this->_sortway = 'desc';
			$_SESSION['defaultsortway'] = $this->_sortway;
		}
		$search = str_replace(' ', ',', $this->_core->getRequest('search'));
		$search = str_replace('  ', ' ', $this->_core->getRequest('search'));
		$arr_s = explode(' ', $search);
		$this->_statuses = $this->_core->getModel('Order/Status/Collection')->newInstance()
			->getCollection('id');
		$this->_items = $this->_core->getModel('Order/Collection')
			->clear()
			->setOrder($this->_sortby[$this->_defaultsort]['order'])
			->setOrderWay($this->_sortway);
		$coll = clone($this->_items);
		if(sizeof($search)>0) {
			foreach ($arr_s as $k=>$str) {
				$this->_items->addGroupFilter('group'.$k, 'email', $str, 'like')
					->addGroupFilter('group'.$k, 'name_first', $str, 'like')
					->addGroupFilter('group'.$k, 'name_last', $str, 'like')
					->addGroupFilter('group'.$k, 'billname_first', $str, 'like')
					->addGroupFilter('group'.$k, 'billname_last', $str, 'like')
					->addGroupFilter('group'.$k, 'shipname_first', $str, 'like')
					->addGroupFilter('group'.$k, 'shipname_last', $str, 'like')
					->addGroupFilter('group'.$k, 'id', $str, 'eq')
					->addGroupFilter('group'.$k, 'created', $str, 'like');
			}
		}
		$this->_items = $this->_items
			->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit)
			->getCollection();
		$this->_totalpages = ceil($coll->getTotal()/$this->_limit);

		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Order', 'Edit')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-order-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
//	 		$this->_toplinks[] = array(
//	 				'url'=>$this->_core->getActionUrl('admin-order-edit'),
//	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRODUCT', 'value')->get('value')
//	 			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Order', 'Remove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-order-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Are you sure you wish to remove "%s" order?'
			);
		}
// 		$this->fetchjs('order', 'list');
		$this->fetch('order', 'list');
		return $this;
	}
}