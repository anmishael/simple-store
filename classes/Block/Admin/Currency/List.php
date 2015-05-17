<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Block_Admin_Currency_List extends Block_Display {
	var $_items;
	function init() {
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Currency', 'Edit')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-currency-edit'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
	 			);
	 		$this->_toplinks[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-currency-edit'),
	 				'name'=>'Add new currency'
	 			);
 		}
 		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Currency', 'Remove')) {
	 		$this->_actions[] = array(
	 				'url'=>$this->_core->getActionUrl('admin-currency-remove'),
	 				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
	 				'warning'=>'Are you sure you wish to remove "%s" currency?'
	 			);
 		}
		$this->_items = $this->_core->getModel('Currency/Collection')->newInstance()->getCollection();
		$this->fetch('currency', 'list');
		return $this;
	}
}