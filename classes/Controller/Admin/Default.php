<?php
/**
 * File: Default.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

 class Controller_Admin_Default extends Controller {
 	var $_user;
 	function actionIndex() {
 		$this->_user = $this->_core->getModel('User/Collection')->getCurrentUser();
		$user = $this->_core->getRequestPost('username');
		$pass = $this->_core->getRequestPost('password');
		if($this->_core->getRequest('u')) $user = $this->_core->getRequest('u');
		 if($this->_core->getRequest('p')) $pass = $this->_core->getRequest('p');
 		if((!$this->_user instanceof Model_User || !$this->_user->get('id')) && $user && $pass) {
 			$this->_user = new Model_User();
 			$this->_user->authorize($user, $pass);
 			if($this->_user->get('id')) {
 				$_SESSION['userid'] = $this->_user->get('id');
 				$this->_core->getModel('User/Collection')->setCurrentUser($this->_user);
				$this->_core->redirect($_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:$this->_core->getSingleton('Config')->adminUrl);
 			}
 		}
 		
 		$this->_core->getBlock('Admin/UserDetails')->init();
 		if($this->_user && $this->_user->get('id')>0) {
 			$this->_core->getBlock('Admin/MenuTop')->init();
 		}
 	}
 }