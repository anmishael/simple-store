<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Controller_Admin_State extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-state-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/State/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/State/Edit')->init();
 	}
 	function actionSave() {
 		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
 			$this->_core->getModel('State');
 			$state = new Model_State($this->_core->getRequestPost());
 			$state->save();
 		}
 		$this->_core->redirect($this->getActionUrl('admin-state-list'));
 	}
 	function actionCity() {
 		$this->_core->redirect($this->getActionUrl('admin-state-city-list'));
 	}
 	function actionCityList() {
 		$this->_core->getBlock('Admin/State/City/List')->init();
 	}
 	function actionCityEdit() {
 		$this->_core->getBlock('Admin/State/City/Edit')->init();
 	}
 	function actionCitySave() {
 		$this->_core->getModel('State/City');
 		$city = new Model_State_City($this->_core->getRequestPost());
 		if($city->save()) {
 			$this->_core->redirect($this->getActionUrl('admin-state-city-list'));
 		} else {
 			$this->_core->raiseError('City saving error!');
 		}
 	}
 	function actionCityApply() {
 		$this->_core->getModel('State/City');
 		if(sizeof($this->_core->getRequest('ids'))>0) {
 			$cities = $this->_core->getModel('State/City/Collection')
 					->newInstance()
 					->addFilter('id', $this->_core->getRequest('ids'), 'in')
 					->getCollection();
 			if($this->_core->getRequest('weight')>=0) {
	 			foreach($cities as $k=>$city) {
	 				$city->push('weight', $this->_core->getRequest('weight'));
	 				$city->save();
	 			}
 			}
 		}
 		$this->_core->redirect($this->getActionUrl('admin-state-city-list').'?' . $this->_core->getAllGetParams(array('ids')));
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-state', $this->_adminUrl . 'state');
 		$this->pushUrl('admin-state-list', $this->_adminUrl . 'state/list');
 		$this->pushUrl('admin-state-edit', $this->_adminUrl . 'state/edit');
 		$this->pushUrl('admin-state-save', $this->_adminUrl . 'state/save');
 		$this->pushUrl('admin-state-remove', $this->_adminUrl . 'state/remove');
 		$this->pushUrl('admin-state-city', $this->_adminUrl . 'state/city');
 		$this->pushUrl('admin-state-city-list', $this->_adminUrl . 'state/city/list');
 		$this->pushUrl('admin-state-city-edit', $this->_adminUrl . 'state/city/edit');
 		$this->pushUrl('admin-state-city-apply', $this->_adminUrl . 'state/city/apply');
 		$this->pushUrl('admin-state-city-save', $this->_adminUrl . 'state/city/save');
 		$this->pushUrl('admin-state-city-remove', $this->_adminUrl . 'state/city/remove');
 		return $this;
 	}
 }