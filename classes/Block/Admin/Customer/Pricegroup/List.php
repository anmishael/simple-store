<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.03.13
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */
class Block_Admin_Customer_Pricegroup_List extends Block_Display {
	var $_items;
	var $_actions;
	function init() {
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'PricegroupEdit')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-pricegroup-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-pricegroup-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRICEGROUP', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'PricegroupRemove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-pricegroup-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Are you sure you wish to remove "%s" price group?'
			);
		}

		$this->_items = $this->_core->getModel('Customer/Pricegroup/Collection')->newInstance()
			->getCollection();
		$this->fetch('customer', 'pricegroup/list');
		return $this;
	}
}
