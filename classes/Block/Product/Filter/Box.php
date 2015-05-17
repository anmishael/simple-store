<?php
/**
 * Created on 19 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Product_Filter_Box extends Block_Display {
	var $_types;
	var $_types_selected;
	var $_filters;
	var $_filters_selected;
	var $_page;
	var $_display = false;
	var $_display_price = false;
	function init() {
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) {
			$this->_display_price = true;
		}
		$this->_blockname = 'contentleft';
		$this->_page = $this->_core->getModel('Page/Collection')->getCurrentPage();
		$filters = $this->_page->fetchProductFilterIDs()->get('filter_ids');
		if(sizeof($filters)>0) {
			$this->_types = $this->_core->getModel('Filter/Type/Collection')->newInstance()
//					->addTable('products_to_filters', 'ptf')
					->addTable('filters', 'f')
					->addFilter('f.id', $filters, 'in')
//					->addFilter('ptf.filter_id', $filters, 'in')
//					->addFilter('ptf.filter_id', 'ptf.filter_id=f.id', 'logic')
					->addFilter('filter_types.id', 'filter_types.id=f.type', 'logic')
					->setGroup('filter_type_description.ftdid');

			$this->_types = $this->_types->getCollection(false,true,true);
			$selFilters = $this->_core->getRequest('filter');
			$sft = array();
			$sf = array();
			foreach($selFilters as $k=>$v) {
				$sft[] = $k;
				foreach($v as $kx=>$vx) {
					$sf[] = $vx;
				}
			}

			$this->_types_selected = $this->_core->getModel('Filter/Type/Collection')->newInstance()
				->addFilter('id', $sft, 'in')
				->getCollection(false, true, true);
//			echo '<pre>'.print_r($selFilters,1).'</pre>';
			foreach($this->_types_selected as $k=>$v) {
				/** @var $v Model_Filter_Type */
				$v->fetchFilters($sf);
			}
//			die('<pre>'.print_r($this->_types_selected,1));
			$ft = false;
			if($this->_params['where']) {
				$ft = array();
				$where = explode(',', $this->_params['where']);
				foreach($where as $k=>$v) {
					$v = explode('=', $v);
					if(strlen(trim($v[0]))>0 && strlen(trim($v[1]))>0) {
						$ft[] = array('key'=>trim($v[0]), 'value'=>trim($v[1]));
					}
				}
			}

			foreach($this->_types as $k=>$v) {
				/** @var $v Model_Filter_Type */
				$arrOtherFilters = array();
				foreach($selFilters as $kx=>$vx) {
					if($kx!=$v->get($v->_id)) {
//						$arrOtherFilters[] = array_merge($arrOtherFilters, $vx);
						foreach($vx as $val) {
							$arrOtherFilters[] = $val;
						}
					}
				}
//				echo 'Other:'.print_r($arrOtherFilters,1).'<br/><br />';
//				echo '<br>----------------------------------------------<br>';
//				$this->_core->setDebug(99);
				$v->fetchFilters($filters, false, false, $ft, array('page'=>$this->_page->get($this->_page->_id)), $arrOtherFilters);
//				$this->_core->setDebug(0);
			}
//			print_r($this->_core->getRequestGet());
			$this->_max_price = $this->_core->getBlock('Page/Content')->_max_price;
			$this->_display = true;
			$this->fetch('filter', 'box');
		}
		return $this;
	}
}