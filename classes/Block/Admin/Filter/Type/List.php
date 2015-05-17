<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Block_Admin_Filter_Type_List extends Block_Display {
 	var $_items;
 	function init() {
 		$this->_items = $this->_core->getModel('Filter/Type/Collection')
 				->clear()
 				->getCollection(false,true,true);
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'TypeEdit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-type-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-type-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_FILTER_TYPE', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'List')) {
 			$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-list'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VIEW_FILTERS', 'value')->get('value'),
	 				'var'=>'typeid'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Filter', 'TypeRemove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-filter-type-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" filter type?'
	 			);
 		}
 		$this->fetch('filter', 'type/list');
 		return $this;
 	}
 }