<?php
/**
 * Created on 30 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Controller_Admin_Language extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Language/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Language/Edit')->init();
 	}
 	function actionSave() {
 		$lng = $this->_core->getModel('Language/Collection')->newInstance()
 				->addFilter('code', $this->_core->getRequest('code'), 'eq')
 				->getOne();
 		if(!$lng instanceof Model_Language || ($lng->get('id') && $lng->get('id')==$this->_core->getRequest('id'))) {
 			$lng = $this->_core->getModel('Language')->newInstance($this->_core->getRequestPost());
 			$lng->save();
 			$this->_core->dispatchEvent('admin-language-save');
 			if($this->_core->getRequestPost('_save') == 'Apply') {
 				$this->_core->redirect($this->getActionUrl('admin-language-edit').'?id='.$lng->get('id'));
 			} else {
 				$this->_core->redirect($this->getActionUrl('admin-language-list'));
 			}
 		} else {
 			$this->_core->raiseError('This language code is already exists');
 		}
 	}
 	function actionRemove() {
		$lng = $this->_core->getModel('Language/Collection')->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if ($lng instanceof Model_Language) {
			$lng->remove();
			$this->_core->dispatchEvent('admin-language-remove', $lng);
		}
		$this->_core->redirect($this->getActionUrl('admin-language-list'));
	}
 		
 	function prepareUrls() {
 		$this->pushUrl('admin-language-list', $this->_adminUrl . 'language/list');
 		$this->pushUrl('admin-language-edit', $this->_adminUrl . 'language/edit');
 		$this->pushUrl('admin-language-save', $this->_adminUrl . 'language/save');
 		$this->pushUrl('admin-language-remove', $this->_adminUrl . 'language/remove');
 	}
 }