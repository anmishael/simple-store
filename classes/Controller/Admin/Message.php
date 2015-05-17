<?php
/**
 * Created on 20 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Controller_Admin_Message extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
 	function actionIndex() {
 		$this->_core->redirect($this->getActionUrl('admin-message-list'));
 	}
 	function actionList() {
 		$this->_core->getBlock('Admin/Message/List')->init();
 	}
 	function actionView() {
 		$this->_core->getBlock('Admin/Message/View')->init();
 	}
 	function actionSend() {
 		if($this->_core->getRequest('id')) {
 			$message = $this->_core->getModel('Customer/Support/Message')->newInstance($this->_core->getRequestPost());
 			$user = $this->_core->getModel('User/Collection')->getCurrentUser();
 			$message->push('uid', $user->get('id'));
 			$message->pop('id');
 			$top = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getOne();
 			$parent = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 						->addFilter('id', $message->get('parent'), 'eq')
 						->setOrder('added')
 						->setOrderWay('desc')
 						->getOne();
 			if(!$parent || !$parent instanceof Model_Customer_Support_Message) {
 				$this->_core->raiseError('Wrong parent message. Please as k system administrator to fix this issue.');
 			} else {
	 			if(!$message->save()) {
	 				$this->_core->raiseError('Message saving error!');
	 			} else {
	 				$template = $this->_core->getModel('Template')->newInstance();
	 				$template->push('title', $message->get('title'))->push('content', $message->get('content'));
	 				
	 				
	 				$email = $this->_core->getModel('Email')->newInstance();
					$email->push('template', $template);
					if($email->send($user->get('email'), $top->get('email'))) {
		 				if($this->_core->getRequestPost('_save') == 'Apply') {
			 				$this->_core->redirect($this->getActionUrl('admin-message-view').'?id='.$this->_core->getRequest('id') . '&' . $this->_core->getAllGetParams(array('id')));
			 			} else {
			 				$this->_core->redirect($this->getActionUrl('admin-message-list') . '?' . $this->_core->getAllGetParams(array('id')));
			 			}
	 				} else {
	 					$this->_core->raiseError('Message send error!');
	 				}
	 			}
 			}
 		}
 	}
 	function actionRemove() {
 		if($this->_core->getRequest('id')) {
 			$message = $this->_core->getModel('Customer/Support/Message/Collection')->newInstance()
 						->addFilter('id', $this->_core->getRequest('id'), 'eq')
 						->getOne();
 			if(is_object($message) && $message instanceof Model_Customer_Support_Message) {
 				if($message->remove()) {
 					$this->_core->redirect($this->getActionUrl('admin-message-list') . '?' . $this->_core->getAllGetParams(array('id')));
 				} else {
 					$this->_core->raiseError('Error removing message!');
 				}
 			}
 		}
 	}
 	function prepareUrls() {
 		$this->pushUrl('admin-message-list', $this->_adminUrl . 'message/list');
 		$this->pushUrl('admin-message-view', $this->_adminUrl . 'message/view');
 		$this->pushUrl('admin-message-send', $this->_adminUrl . 'message/send');
 		$this->pushUrl('admin-message-remove', $this->_adminUrl . 'message/remove');
 	}
 }