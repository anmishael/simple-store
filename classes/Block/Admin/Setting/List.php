<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Setting_List extends Block_Display {
 	var $_items;
 	var $_total = 0;
 	var $_page = 1;
 	var $_result_perpage = 10;
 	function init() {
 		$coll = $this->_core->getModel('Setting/Collection')->newInstance();
 		if(is_string($this->_core->getRequestGet('sort')) && isset($_sorts[$this->_core->getRequestGet('sort')])) {
 			$coll->setOrder($_sorts[$this->_core->getRequestGet('sort')]);
 		}
 		if($this->_core->getRequest('search')) {
 			$search = strip_tags($this->_core->getRequest('search'));
 			$coll->addFilter('`key`', $search, 'like');
 			$coll->addFilter('`value`', $search, 'like');
 			$coll->setSqlSplit('OR');
 		}
 		$this->_total = $coll->getTotal();
 		$this->_totalpages = ceil($this->_total/$this->_result_perpage);
 		
 		$this->_page = (int)$this->_core->getRequestGet('_p')>0 ? (int)$this->_core->getRequestGet('_p') : 1;
 		
 		$this->_items = $coll->setLimit(( $this->_page*$this->_result_perpage-$this->_result_perpage) . ', ' . $this->_result_perpage)->getCollection();
 		
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Setting', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-setting-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-setting-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_SETTING', 'value')->get('value')
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Setting', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-setting-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" setting?'
	 			);
 		}
 		
 		$this->fetch('setting', 'list');
 		return $this;
 	}
 }