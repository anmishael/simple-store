<?php
/**
 * File: Filter.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

 class Block_Product_Filter extends Block_Display {
 	var $_items;
 	var $_filters;
 	var $_features;
 	function init() {
 		$this->_features = $this->_core->getModel('Filter/Type/Collection')->clear()->getCollection();
 		foreach($this->_features as $k=>$v) {
 			$this->_features[$k]->loadFilters();
 		}
 		$types = $this->_core->getModel('Product/Type/Collection')->clear()->getCollection();
 		$_art = array();
 		foreach($types as $k=>$v) {
 			$_art[] = array('value'=>$v->get('id'), 'name'=>$v->get('name'));
 		}
 		if(sizeof($_art)>0) {
 			$this->_filters['types'] = $_art;
 		}
 		$this->fetch('product', 'filter');
 		return $this;
 	}
 }