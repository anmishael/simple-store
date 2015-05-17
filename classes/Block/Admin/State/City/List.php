<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_State_City_List extends Block_Display {
 	var $_items;
 	var $_states;
 	var $_weights = array('Small', 'Medium', 'Large');
 	var $_counties;
 	function init() {
// 		$search = str_replace(' ', ',', $this->_core->getRequest('search'));
 		$search = str_replace('  ', ' ', $this->_core->getRequest('search'));
 		
 		$arr_s = explode(',', $search);
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('State', 'CityEdit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-city-edit'),
	 				'name'=>'edit'
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-city-edit'),
	 				'name'=>'Add new city'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('State', 'CityRemove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-state-city-remove'),
	 				'name'=>'remove',
	 				'warning'=>'Are you sure you wish to remove "%s" city?'
	 			);
 		}
 		$states = $this->_core->getModel('State/Collection')->clear()->getCollection();
 		foreach($states as $k=>$v) {
 			$this->_states[$v->get('id')] = $v;
 			unset($states[$k]);
 		}
 		$states = null;
 		$ccoll = $this->_core->getModel('State/County/Collection')->newInstance()->getCollection();
 		foreach($ccoll as $k=>$v) {
 			$this->_counties[$v->get('id')] = $v;
 		}
 		$ccoll = $this->_core->getModel('State/City/Collection')
 				->clear()
 				->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit);
 		
 		if(sizeof($arr_s)>0) {
 			foreach($arr_s as $x=>$nm) {
	 			$ccoll->addFilter('name', trim($nm), 'like');
	 			$ccoll->addFilter('zip', trim($nm), 'like');
//	 			$ccoll->setSqlSplit('OR');
	 			
	 			$scoll = $this->_core->getModel('State/Collection')
	 					->newInstance()
	 					->addFilter('code', trim($nm), 'like')
	 					->setSqlSplit('OR')
	 					->getCollection();
	 			if(sizeof($scoll)>0) {
	 				foreach($scoll as $k=>$v) {
	 					$ccoll->addFilter('state', $v->get('id'), 'eq');
	 				}
	 			}
 			}
 		}
 		if((int)$this->_core->getRequest('_s')>0) {
 			$ccoll->addFilter('state', (int)$this->_core->getRequest('_s'), 'eq');
 		}
 		$this->_items = $ccoll->getCollection();
 		$this->_totalpages = ceil($this->_core->getModel('State/City/Collection')->_total/$this->_limit);
 		
 		$this->fetch('state/city', 'list');
 	}
 }