<?php
/*
 * Created on 10 ���. 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Controller_Admin_Template extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareUrls();
	}
	function actionIndex() {
		$this->_core->redirect($this->getActionUrl('admin-template-list'));
	}
	function actionList() {
		$this->_core->getBlock('Admin/Template/List')->init();
	}
	function actionEdit() {
		$this->_core->getBlock('Admin/Template/Edit')->init();
	}
	function actionSave() {
		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
			$errors = array();
			if(!$this->_core->notNull($this->_core->getRequest('name'))) {
				$errors[] = 'Name';
			}
			if(!$this->_core->notNull($this->_core->getRequest('code'))) {
				$errors[] = 'Code';
			}
			$template = $this->_core->getModel('Template')->newInstance($this->_core->getRequestPost());
			if($this->_core->notNull($errors)) {
				$this->_core->raiseError('Please enter required fields: ' . implode(', ', $errors));
				$this->_core->getBlock('Admin/Template/Edit')->init();
				return false;
			} else {
				$template->save();
			}
		}
		if($this->_core->getRequestPost('_save') == 'Apply') {
			$this->_core->redirect($this->getActionUrl('admin-template-edit').'?id=' . $template->get('id'));
		} else {
			$this->_core->redirect($this->getActionUrl('admin-template-list'));
		}
	}
	function actionRemove() {
		if($this->_core->getRequest('id')) {
			$template = $this->_core->getModel('Template/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if(is_object($template) && $template instanceof Model_Template) {
				$template->remove();
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-template-list'));
	}
	function prepareUrls() {
		$this->pushUrl('admin-template', $this->_adminUrl . 'template');
		$this->pushUrl('admin-template-list', $this->_adminUrl . 'template/list');
		$this->pushUrl('admin-template-edit', $this->_adminUrl . 'template/edit');
		$this->pushUrl('admin-template-save', $this->_adminUrl . 'template/save');
		$this->pushUrl('admin-template-remove', $this->_adminUrl . 'template/remove');
	}
}