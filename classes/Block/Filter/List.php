<?php
/**
* Created on 19 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/

class Block_Filter_List extends Block_Display {
	var $_items;
	var $_filter_type;
	function init() {
		$this->_items = $this->_core->getModel('Filter/Collection')->newInstance();
		if($this->_params['block_name']) {
			$this->_blockname = $this->_params['block_name'];
		}
		if($this->_params['filter_type']) {
			$typeid = $this->_params['filter_type'];
			if(!is_numeric($this->_params['type'])) {
				$this->_filter_type = $this->_core->getModel('Filter/Type/Collection')->addFilter('url', $typeid, 'eq')->getOne();
				if($this->_filter_type instanceof Model_Filter_Type) {
					$typeid = $this->_filter_type->get('id');
				}
			} else {
				$this->_filter_type = $this->_core->getModel('Filter/Type/Collection')->addFilter('id', $typeid, 'eq')->getOne();
			}
			if(!$this->_filter_type instanceof Model_Filter_Type) {
				$typeid = 0;
			}
			$this->_items->addFilter('type', $typeid, 'eq');
		}
		$ft = false;
		if($this->_params['where']) {
			$ft = array();
			$where = explode(',', $this->_params['where']);
			foreach($where as $k=>$v) {
				$v = explode('=', $v);
				if(strlen(trim($v[0]))>0 && strlen(trim($v[1]))>0) {
					$this->_items->addFilter(trim($v[0]), trim($v[1]), 'eq');
				}
			}
		}
		if(!$this->_filter_type instanceof Model_Filter_Type) {
			$this->_filter_type = $this->_core->getModel('Filter/Type')->newInstance();
			$typeid = 0;
		}
		$this->_items = $this->_items->getCollection(false,true,true);

		$this->fetch('filter', $this->_filter_type->get('url') . '/list');
		return $this;
	}
}