<?php
/**
 * Created on 23 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Controller_Admin_Order extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-order-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Order/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Order/Edit')->init();
 	}
 	function actionSave() {
 		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
 			if($this->_core->getRequest('id')) {
 				$order = $this->_core->getModel('Order/Collection')->newInstance()
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getOne();
 				if($order instanceof Model_Order) {
 					$post = $this->_core->getRequestPost();
 					foreach($post as $k=>$v) {
 						$order->push($k, $v);
 					}
 					$order->save();
 				}
 			}
 		}
 		$this->_core->redirect($this->getActionUrl('admin-order-list'));
 	}
	function actionExport() {
		if($this->_core->getRequest('id')) {
			if($this->_core->getRequest('tofile')) {
				$order = $this->_core->getModel('Order/Collection')->newInstance()
					->addFilter('id', $this->_core->getRequest('id'), 'eq')
					->getOne();
				if($order instanceof Model_Order) {
					$order->export();
					die();
				}
			} else {
				$this->_core->getBlock('Admin/Order/Export/Xml')->init();
			}
		}
	}
	function actionRemove() {
		if($this->_core->getRequest('id')) {
			$this->_core->setDebug(99);
			$order = $this->_core->getModel('Order/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($order instanceof Model_Order) {
				$this->_core->dispatchEvent('order-remove-before', $order);
				$order->remove();
				$this->_core->dispatchEvent('order-remove-after', $order);
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-order-list'));
	}
 	function prepareUrls() {
 		$this->pushUrl('admin-order', $this->_adminUrl . 'order');
 		$this->pushUrl('admin-order-list', $this->_adminUrl . 'order/list');
 		$this->pushUrl('admin-order-edit', $this->_adminUrl . 'order/edit');
 		$this->pushUrl('admin-order-save', $this->_adminUrl . 'order/save');
 		$this->pushUrl('admin-order-remove', $this->_adminUrl . 'order/remove');
		 $this->pushUrl('admin-order-export', $this->_adminUrl . 'order/export');
 		return $this;
 	}
}