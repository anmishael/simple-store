<?php
/**
 * Created on 23 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Admin_Order_Edit extends Block_Display {
	var $_item;
	var $_statuses;
	var $_toplinks = array();
	function init() {
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Order', 'Export')) {
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-order-export'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EXPORT', 'value')->get('value'),
				'warning'=>'Are you sure you wish to export "%s" order?'
			);
		}

		if($this->_core->getRequest('id')) {
			$statuses = $this->_core->getModel('Order/Status/Collection')->newInstance()->getCollection('key');
			$this->_item = $this->_core->getModel('Order/Collection')->newInstance()
					->addFilter('orders.id', $this->_core->getRequest('id'), 'eq')
					->addTable('users', 'u', array('u.username', 'u.name_first as user_name_first', 'u.name_last as user_name_last', 'u.email as user_email'), 'u.id=orders.user')
					->getOne();

			if($this->_item instanceof Model_Order) {
				if(!$this->_item->get('shipping')) {
					$shipping = $this->_core->getModel('Shipping/Collection')->newInstance()
						->addGroupFilter('search', 'name', $this->_item->get('shipping_method'), 'like')
						->addGroupFilter('search', 'label', $this->_item->get('shipping_method'), 'like')
						->getOne();
					if(!$shipping instanceof Model_Shipping) {
						$this->_core->raiseError('Missing shipping method "'.$this->_item->get('shipping_method').'"');
						return $this;
					}
					$this->_item->push('shipping', $shipping->get($shipping->_id));
					$this->_item->push('changed', 'NOW()')->save();
				}
				if(!$this->_item->get('user')) {
					$this->_item->push('user', $this->_core->getModel('User/Collection')->getCurrentUser()->get('id'))->push('opened', 'NOW()')->save();
					$this->_item = $this->_core->getModel('Order/Collection')->newInstance()
					->addFilter('orders.id', $this->_core->getRequest('id'), 'eq')
					->addTable('users', 'u', array('u.username', 'u.name_first as user_name_first', 'u.name_last as user_name_last', 'u.email as user_email'), 'u.id=orders.user')
					->getOne();
				}
				if(
					$this->_item->get('status') == $statuses['unpaid']->get('id')
					||
					$this->_item->get('status') == $statuses['pending']->get('id')
				) {
					$this->_item->push('status', $statuses['processed']->get('id'))->push('changed', 'NOW()')->save();
				}
				$this->_currency = $this->_core->getModel('Currency/Collection')->newInstance()
					->addFilter('code', $this->_item->get('currency'), 'eq')
					->getOne();
				$this->_statuses = $this->_core->getModel('Order/Status/Collection')->newInstance()
						->getCollection('id');
				$this->_item->fetchProducts();
				$this->fetch('order', 'edit');
			}
		}
		return $this;
	}
}