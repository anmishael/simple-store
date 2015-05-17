<?php
/*
 * Created on May 24, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Controller_Admin_User extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-user-list'));
 	}
 	function actionLogout() {
 		session_destroy();
 		$this->_core->redirect($this->_core->getSingleton('Config')->adminUrl);
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/User/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/User/Edit')->init();
 	}
 	function actionSave() {
 		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
 			$this->_core->getModel('User');
 			$user = new Model_User($this->_core->getRequestPost());
 			$user->save();
 		}
 		$this->_core->redirect($this->getActionUrl('admin-user-list'));
 	}
	 function actionRemove() {
		 $user = $this->_core->getModel('User/Collection')->newInstance()
			 ->addFilter('id', $this->_core->getRequest('id'), 'eq')
			 ->getOne();
		 if($user instanceof Model_User) {
			 $user->remove();
		 }
		 $this->_core->redirect($this->getActionUrl('admin-user-list'));
	 }
 	function actionType() {
 		$this->_core->redirect($this->getActionUrl('admin-user-type-list'));
 	}
 	function actionTypeList() {
 		$this->_core->getBlock('Admin/User/Type/List')->init();
 	}
 	function actionTypeEdit() {
 		$this->_core->getBlock('Admin/User/Type/Edit')->init();
 	}
 	function actionTypeSave() {
		$this->_core->getModel('User/Type');
		$type = new Model_User_Type($this->_core->getRequestPost());
		if($type->get('id')>1 && $type->get('id')<=$this->_core->getModel('User/Collection')->getCurrentUser()->get('typeid')) {
			$this->_core->raiseError('You\'re not able to made changes for that user type!');
		} else {
			if($type->save()) {
				$this->_core->redirect($this->getActionUrl('admin-user-type-list'));
			}
		}
 	}
 	function actionTypeRemove() {
		$type = $this->_core->getModel('User/Type/Collection')->getUserType($this->_core->getRequest('id'));
		if($type->get('id')>1 && $type->get('id')<=$this->_core->getModel('User/Collection')->getCurrentUser()->get('typeid')) {
			$this->_core->raiseError('You\'re not able to remove that user type!');
		} else {
			if($type->remove()) {
				$this->_core->redirect($this->getActionUrl('admin-user-type-list'));
			}
		}
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-user-list', $this->_adminUrl . 'user/list');
 		$this->pushUrl('admin-user-edit', $this->_adminUrl . 'user/edit');
 		$this->pushUrl('admin-user-save', $this->_adminUrl . 'user/save');
 		$this->pushUrl('admin-user-remove', $this->_adminUrl . 'user/remove');
 		$this->pushUrl('admin-user-type-list', $this->_adminUrl . 'user/type/list');
 		$this->pushUrl('admin-user-type-edit', $this->_adminUrl . 'user/type/edit');
 		$this->pushUrl('admin-user-type-save', $this->_adminUrl . 'user/type/save');
 		$this->pushUrl('admin-user-type-remove', $this->_adminUrl . 'user/type/remove');
 		return $this;
 	}
 }