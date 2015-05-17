<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Block_Product_List extends Block_Display {
	var $_products = array();
	var $_total = 0;
	var $_page = 1;
	var $_result_perpage = 10;
	var $_maxshortdesc = 40;
	var $_features;
	var $_favorites = array();
	var $_view = 'list';
	var $_sortby;
	var $_rowlength = 4;
	var $_display_price = false;
	function init() {
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) {
			$this->_display_price = true;
		}
		$this->_sortby = array(
			'name'=>array(
				'order'=>'name',
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

		$this->setParam('rowlength', $rowlength);
		$this->_current_page = (int)$this->_core->getRequestGet('_p')>0 ? (int)$this->_core->getRequestGet('_p') : 1;
		$this->_limit_start = ( $this->_current_page*$result_perpage-$result_perpage);

		$pcoll = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('status', 0, 'neq')
			->setLimit($this->_limit_start . ', ' . $result_perpage)
			->setOrder($this->_sortby[$this->_defaultsort]['order'])
			->setOrderWay($this->_sortby[$this->_defaultsort]['way'])
			->addOption('SQL_CALC_FOUND_ROWS')
			->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
			->setGroup('bundle_ids')
			->addField('IF(p2b.bundle_id IS NULL, CONCAT(RAND(3), \'null\', id), CONCAT(p2b.bundle_id, \'\')) as bundle_ids');
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$pcoll->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		if($this->_params['where']) {
			$ft = array();
			$where = explode(',', $this->_params['where']);
			foreach($where as $k=>$v) {
				if(stristr($v, '=')) {
					$v = explode('=', $v);
					if(strlen(trim($v[0]))>0 && strlen(trim($v[1]))>0) {
						$pcoll->addFilter($v[0], $v[1], 'eq');
					}
				}
			}
		}
		if($this->_params['filter']) {
			$ft = array();
			$where = explode(',', $this->_params['filter']);
			$pcoll->addTable('products_to_filters', 'p2f')
				->addFilter('filter', 'p2f.product_id=products.id', 'logic')
				->addFilter('p2f.filter_id', $where, 'in');
		}
		if($this->_core->getRequest('status') == 'new') {
			$pcoll->addFilter('status_new', 1, 'eq');
		}
		if($this->_core->getRequest('status') == 'action') {
			$pcoll->addFilter('status_action', 1, 'eq');
		}
		if($this->_core->getRequest('status') == 'topsell') {
			$pcoll->addFilter('status_topsell', 1, 'eq');
		}
		if($this->_params['limit']) {
			$pcoll->setLimit($this->_params['limit']);
		}
		if($this->_params['order']) {
			$pcoll->setOrder($this->_params['order']);
		}
//		$this->_core->setDebug(99);
		$this->_items = $pcoll->getCollection(false,true,true);
//		$this->_core->setDebug(0);
		$this->_total = $pcoll->getLastTotal();
		$this->_totalpages = ceil($this->_total/$result_perpage);

		if(!$this->_items) $this->_items = array();
		if($this->_core->getBlock('Product/Filter/Box')->init()->_display) {
			$this->setParam('rowlength', $this->_rowlength);
			$this->_totalpages = ceil($this->_total/$result_perpage);
		}
// 		die($this->_limit_start . ', ' . $result_perpage);
		if(sizeof($this->_items)>0) {
			$this->fetch('product', $this->_view);
			$this->fetchjs('product', $this->_view);
		}
		return $this;
	}
}