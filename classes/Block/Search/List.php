<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Search_List extends Block_Display {
 	var $_products = array();
 	var $_total = 0;
 	var $_page = 1;
 	var $_result_perpage = 32;
 	var $_maxshortdesc = 40;
 	var $_features;
 	var $_favorites = array();
 	var $_view = 'list';
 	var $_sortby;
 	var $_rowlength = 4;
 	var $_items;
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
 		
		$string = trim($this->_core->getRequestGet('search'));
//		$pcoll = $this->_core->getModel('Product/Collection')->newInstance();
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance()
			->addFilter('status', 0, 'neq')
			->setLimit($this->_limit_start . ', ' . $result_perpage)
			->setOrder($this->_sortby[$this->_defaultsort]['order'])
			->setOrderWay($this->_sortby[$this->_defaultsort]['way'])
			->addOption('SQL_CALC_FOUND_ROWS')
			->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
			->setGroup('bundle_ids')
			->addField('IF(p2b.bundle_id IS NULL, CONCAT(RAND(3), \'null\', id), CONCAT(p2b.bundle_id, \'\')) as bundle_ids');
		$arrstr = explode(' ', str_replace('  ', ' ', $string));
		if(sizeof($arrstr)>0 && $this->_core->notNull($arrstr)) {
			foreach ($arrstr as $k=>$str) {
				$pcoll->addGroupFilter('group'.$k, 'name', $str, 'like')
					->addGroupFilter('group'.$k, 'sku', $str, 'like')
					->addGroupFilter('group'.$k, 'code', $str, 'like');
//				$pcoll->addGroupFilter('group'.$k)
			}
//			$pcoll->setLimit($this->_limit_start . ', ' . $result_perpage)
//	 				->setOrder($this->_sortby[$this->_defaultsort]['order'])
//	 				->setOrderWay($this->_sortby[$this->_defaultsort]['way']);
//			$pcoll->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
//				->setGroup('p2b.bundle_id');
			$this->_items = $pcoll->getCollection(false,true,true);
			if(sizeof($this->_items)>0) {
				if($this->_core->getRequest('view') && in_array($this->_core->getRequest('view'), array('grid', 'list', 'window'))) {
					$this->_view = $this->_core->getRequest('view');
					$_SESSION['view'] = $this->_view;
				} elseif($_SESSION['view']) {
					$this->_view = $_SESSION['view'];
				}
				$this->_total = $pcoll->getLastTotal();
		 		$this->_totalpages = ceil($this->_total/$result_perpage);
//				$this->fetch('product', $this->_view);
				$this->fetch('product', 'list');
			}
		}
	}
}