<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Block_Admin_Filter_List extends Block_Display {
 	var $_items = array();
 	var $_types = array();
 	var $_type;
 	function init() {
 		$this->_items = $this->_core->getModel('Filter/Collection')->newInstance();
 		if((int)$this->_core->getRequest('typeid')>0) {
 			$this->_items->addFilter('type', $this->_core->getRequest('typeid'), 'eq');
 			$this->_type = $this->_core->getmodel('Filter/Type/Collection')->newInstance()
 					->addFilter('id', (int)$this->_core->getRequest('typeid'), 'eq')
 					->getCollection(false,true,true);
 			if(isset($this->_type[0]) && $this->_type[0] instanceof Model_Filter_Type) {
 				$this->_type = $this->_type[0];
 			} else {
 				$this->_type = new Model_Filter_Type();
 			}
 		}
// 		$this->_core->getResource('DB')->getConnection()->debug=1;
 		$this->_items = $this->_items->setOrder('name')->setOrderWay('asc')->getCollection(false,true,true);
// 		print_r($this->_items[0]);
 		
 		$_types = $this->_core->getModel('Filter/Type/Collection')->newInstance()->getCollection(false,true,true);
// 		$this->_core->getResource('DB')->getConnection()->debug=0;
 		foreach($_types as $k=>$v) {
 			$this->_types[$v->get('id')] = $v;
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-edit') . (((int)$this->_core->getRequest('typeid')>0)?'?typeid=' . (int)$this->_core->getRequest('typeid') : ''),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_FILTER', 'value')->get('value')
	 			);
 		}
 		if((int)$this->_core->getRequest('typeid')>0 && $this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'List')) {
 			$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-list'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW_ALL_FILTERS', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'TypeList')) {
 			$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-type-list'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW_FILTER_TYPES', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" filter?'
	 			);
 		}
 		$this->fetch('filter', 'list');
 		return $this;
 	}
 }