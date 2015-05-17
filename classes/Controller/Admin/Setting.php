<?php
/**
 * Created on 19 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Controller_Admin_Setting extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-setting-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Setting/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Setting/Edit')->init();
 	}
 	function actionSave() {
 		if($this->_core->getRequest('key')) {
 			$setting = $this->_core->getModel('Setting')->newInstance($this->_core->getRequestPost());
 			if($this->_core->getRequest('id')) {
 				$oldsetting = $this->_core->getModel('Setting/Collection')->newInstance()
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getOne();
 				if(is_object($oldsetting) && $oldsetting instanceof Model_Setting && $oldsetting->get('type') == 'password') {
 					$setting->pop('type');
 				}
 			}
 			if(!$setting->save()) {
 				$this->_core->raiseError('Error saving setting item!');
 			} else {
 				if($this->_core->getRequestPost('_save') == 'Apply') {
	 				$this->_core->redirect($this->getActionUrl('admin-setting-edit').'?id='.$setting->get('id') . '&' . $this->_core->getAllGetParams(array('id')));
	 			} else {
	 				$this->_core->redirect($this->getActionUrl('admin-setting-list') . '?' . $this->_core->getAllGetParams(array('id')));
	 			}
 			}
 		}
 	}
 	function actionRemove() {
 		if($this->_core->getRequest('id')) {
 			$setting = $this->_core->getModel('Setting/Collection')->newInstance()
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getOne();
 			if(is_object($setting) && $setting instanceof Model_Setting) {
 				if($setting->remove()) {
 					$this->_core->redirect($this->getActionUrl('admin-setting-list') . '?' . $this->_core->getAllGetParams(array('id')));
 				} else {
 					$this->_core->raiseError('Error removing setting item!');
 				}
 			}
 		}
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-setting-list', $this->_adminUrl . 'setting/list');
 		$this->pushUrl('admin-setting-edit', $this->_adminUrl . 'setting/edit');
 		$this->pushUrl('admin-setting-save', $this->_adminUrl . 'setting/save');
 		$this->pushUrl('admin-setting-remove', $this->_adminUrl . 'setting/remove');
 	}
 }