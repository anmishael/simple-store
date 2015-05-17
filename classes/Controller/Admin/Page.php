<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Controller_Admin_Page extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-page-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Page/List')->init();
 	}
 	function actionEdit() {
 		$this->_core->getBlock('Admin/Page/Edit')->init();
 	}
 	function actionSave() {
 		$this->_core->getModel('Page');
 		$page = new Model_Page($this->_core->getRequestPost());
 		$page->set('menu', $this->_core->getRequestPost('menu'));
 		if(!$page->get('menu')) {
 			$page->set('menu', array());
 		}
 		if($page->save()) {
 			if($this->_core->getRequestPost('_save') == 'Apply') {
 				$this->_core->redirect($this->getActionUrl('admin-page-edit').'?id='.$page->get('id'));
 			} else {
 				$this->_core->redirect($this->getActionUrl('admin-page-list'));
 			}
 		} else {
 			$this->_core->raiseError('Page saving error!');
 		}
 	}
 	function actionUpload() {
 		$this->_core->getModel('Page');
 		$page = new Model_Page($this->_core->getRequestPost());
 		if($page->get('id') && is_uploaded_file($_FILES['image']['tmp_name'])) {
// 			die($this->_core->getSingleton('Config')->getPath() . 'images/pages/' . $page->get('id') . '/');
			$destination = $this->_core->getSingleton('Config')->getPath() . 'images'.$this->_core->getSystemSlash().'pages' . $this->_core->getSystemSlash() . $page->get('id') . $this->_core->getSystemSlash();
 			$this->_core->mkFolders($destination);
 			if(move_uploaded_file($_FILES['image']['tmp_name'], $destination . $_FILES['image']['name'])) {
 				$this->_core->redirect($this->getActionUrl('admin-page-edit') . '?id=' . $page->get('id'));
 			} else {
 				$this->_core->raiseError('Error moving file \''.$_FILES['image']['tmp_name'].'\' to \''.$destination.$_FILES['image']['name'].'\'!');
 			}
 		} 
 	}
 	function actionRemove() {
 		$page = $this->_core->getModel('Page/Collection')
 			->clear()
 			->addFilter('id', $this->_core->getRequest('id'), 'eq')
 			->getOne();
 		if($page instanceof Model_Page) {
 			$page->remove();
 		}
 		$this->_core->redirect($this->getActionUrl('admin-page-list'));
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-page-list', $this->_adminUrl . 'page/list');
 		$this->pushUrl('admin-page-edit', $this->_adminUrl . 'page/edit');
 		$this->pushUrl('admin-page-save', $this->_adminUrl . 'page/save');
 		$this->pushUrl('admin-page-upload', $this->_adminUrl . 'page/upload');
 		$this->pushUrl('admin-page-remove', $this->_adminUrl . 'page/remove');
 		return $this;
 	}
 }