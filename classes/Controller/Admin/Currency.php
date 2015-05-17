<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Controller_Admin_Currency extends Controller {
	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-currency-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Currency/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Currency/Edit')->init();
 	}
 	function actionSave() {
 		$item = $this->_core->getModel('Currency')->newInstance($this->_core->getRequestPost());
 		if($item->save()) {
 			$this->_core->redirect($this->getActionUrl('admin-currency-list'));
 		}
 	}
 	function actionRemove() {
 		$item = $this->_core->getModel('Currency/Collection')->newInstance()
 				->addFilter('id', $this->_core->getRequest('id'), 'eq')
 				->getOne();
 		if($item->remove()) {
 			$this->_core->redirect($this->getActionUrl('admin-currency-list'));
 		}
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-currency-list', $this->_adminUrl . 'currency/list');
 		$this->pushUrl('admin-currency-edit', $this->_adminUrl . 'currency/edit');
 		$this->pushUrl('admin-currency-save', $this->_adminUrl . 'currency/save');
 		$this->pushUrl('admin-currency-remove', $this->_adminUrl . 'currency/remove');
 		return $this;
 	}
}