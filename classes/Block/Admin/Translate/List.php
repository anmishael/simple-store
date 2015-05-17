<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */

class Block_Admin_Translate_List extends Block_Display {
	var $_items;
	var $_languages;
	function init() {
		$search = str_replace(' ', ',', $this->_core->getRequest('search'));
		$search = str_replace('  ', ' ', $this->_core->getRequest('search'));
		$arr_s = explode(' ', $search);
		
		$this->_languages = $this->_core->getModel('Language/Collection')->newInstance()->getCollection($this->_core->getModel('Language')->_id);
		
		$this->_items = $this->_core->getModel('Translate/Collection')->newInstance()
				->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit);
		if(sizeof($arr_s)>0) {
//			$this->_items->addFilter('`key`', $arr_s, 'like');
			$this->_items->addGroupFilter('keyvalue', '`key`', $arr_s, 'like');
			$this->_items->addGroupFilter('keyvalue', '`value`', $arr_s, 'like');
		}
// 		$this->_core->getResource('DB')->getConnection()->debug=1;
		$this->_items = $this->_items->getCollection();
		$this->_totalpages = $this->_core->getModel('Translate/Collection')->newInstance();
		if(sizeof($arr_s)>0) {
			$this->_totalpages->addFilter('`key`', $arr_s, 'like');
		}
		$this->_totalpages = ceil($this->_totalpages->getTotal()/$this->_limit);

		if(!$this->_item instanceof Model_Translate || !$this->_item->get($this->_item->_id)) {
			$this->_item = $this->_core->getModel('Translate')->newInstance();
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Translate', 'Edit')) {
			$this->_actions[] = array(
					'url'=>$this->_core->getActionUrl('admin-translate-edit'),
					'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
			$this->_toplinks[] = array(
					'url'=>$this->_core->getActionUrl('admin-translate-edit'),
					'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_TRANSLATION', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Translate', 'Remove')) {
			$this->_actions[] = array(
					'url'=>$this->_core->getActionUrl('admin-translate-remove'),
					'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
					'warning'=>'Are you sure you wish to remove "%s" translation?'
			);
		}
		$this->fetch('translate', 'list');
		return $this;
	}
}