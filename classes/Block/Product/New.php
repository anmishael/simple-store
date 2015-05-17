<?php
/**
* Created on 21 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
*/

class Block_Product_New extends Block_Display {
	var $_items;
 	var $_total = 0;
 	var $_page = 1;
 	var $_result_perpage = 6;
 	var $_rowlength = 3;
	function init() {
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance();
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$pcoll->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		if($this->_params['limit']) {
//			$this->_items->setLimit($this->_params['limit']);
			$this->_result_perpage = $this->_params['limit'];
			$this->_rowlength = $this->_rowlength*2;
		}
		$rowlength = $this->_rowlength;
 		$result_perpage = $this->_result_perpage;
 		$this->_current_page = (int)$this->_core->getRequestGet('_p')>0 ? (int)$this->_core->getRequestGet('_p') : 1;
 		$this->_limit_start = ( $this->_current_page*$result_perpage-$result_perpage);
 		
		if($this->_params['exclude']) {
			$pcoll->addFilter('id', explode(',', $this->_params['exclude']), 'notin');
		}
		$pcoll->addFilter('status', 0, 'neq')->setLimit($this->_limit_start . ', ' . $result_perpage)->setOrder('added')->setOrderWay('desc');
		$this->_items = $pcoll->getCollection(false, true, true);
		$this->_total = $pcoll->setOrder('')->setLimit('')->getTotal();
		$this->_totalpages = ceil($this->_total/$result_perpage);
		
		$this->fetch('product', 'grid');
		return $this;
	}
}