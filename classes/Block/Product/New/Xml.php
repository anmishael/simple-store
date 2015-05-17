<?php
/**
 * Created on 26 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Product_New_Xml extends Block_Display {
	var $_items;
 	var $_total = 0;
 	var $_page = 1;
 	var $_result_perpage = 6;
 	var $_rowlength = 3;
	function init() {
		$pcoll = $this->_core->getModel('Product/Collection')->newInstance();
		if($this->_params['limit']) {
//			$this->_items->setLimit($this->_params['limit']);
			$this->_result_perpage = $this->_params['limit'];
			$this->_rowlength = $this->_rowlength*2;
		}
		$rowlength = $this->_rowlength;
 		$result_perpage = $this->_result_perpage;
 		$this->_current_page = (int)$this->_core->getRequestGet('_p')>0 ? (int)$this->_core->getRequestGet('_p') : 1;
 		$this->_limit_start = ( $this->_current_page*$result_perpage-$result_perpage);
 		if($this->_core->getRequest('exclude')) $this->_params['exclude'] = $this->_core->getRequest('exclude');
		if($this->_params['exclude']) {
			$pcoll->addFilter('id', explode(',', $this->_params['exclude']), 'notin');
		}
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$pcoll->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		$pcoll->setLimit($this->_limit_start . ', ' . $result_perpage)->setOrder('added')->setOrderWay('desc');
		$this->_items = $pcoll->getCollection(false, true, true);
		$this->_total = $pcoll->setOrder('')->setLimit('')->getTotal();
		$this->_totalpages = ceil($this->_total/$result_perpage);
		
		$this->fetch('product', 'new/xml');
		return $this;
	}
}