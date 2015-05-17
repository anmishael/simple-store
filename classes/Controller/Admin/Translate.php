<?php
/**
 * Created on 30 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Controller_Admin_Translate extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Translate/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Translate/Edit')->init();
 	}
 	function actionSave() {
//  		$lng = null;//$this->_core->getModel('Translate/Collection')->newInstance()
//  				->addFilter('key', $this->_core->getRequest('key'), 'eq')
//  				->getOne();
//  		if(!$this->_core->getRequest('id')) {
 			$translate = $this->_core->getModel('Translate')->newInstance($this->_core->getRequestPost());
//  		} else {
 			$translate = $this->_core->getModel('Translate')->newInstance($this->_core->getRequestPost());
//  				->push($this->_core->getModel('Translate')->_id, $this->_core->getRequest('id'));
//  		}
//   		die('<pre>'.print_r($translate,1).'</pre>');
// 		$this->_core->getResource('DB/MySQL')->debug=1;
 		if($translate->save()) {
 			$this->_core->dispatchEvent('admin-translate-save');
	 		if($this->_core->getRequestPost('_save') == 'Apply') {
				$this->_core->redirect($this->getActionUrl('admin-translate-edit') . '?id=' . $translate->get($translate->_id).'&'.$this->_core->getAllGetParams(array('id')));
	 		} else {
				$this->_core->redirect($this->getActionUrl('admin-translate-list').'?'.$this->_core->getAllGetParams(array('id')));
	 		}
 		} else {
 			$this->_core->raiseError('Translation saving error!');
 		}
 	}
 	function actionRemove() {
 		
 	}

	function removeLanguage($lng) {
		$res = false;
		if ($lng instanceof Model_Language) {
			$res = $this->_core->getModel('Translate/Collection')->removeLanguage($lng);
		}
		return $res;
	}

 	function prepareUrls() {
 		$this->pushUrl('admin-translate-list', $this->_adminUrl . 'translate/list');
 		$this->pushUrl('admin-translate-edit', $this->_adminUrl . 'translate/edit');
 		$this->pushUrl('admin-translate-save', $this->_adminUrl . 'translate/save');
 		$this->pushUrl('admin-translate-remove', $this->_adminUrl . 'translate/remove');
 	}
 }