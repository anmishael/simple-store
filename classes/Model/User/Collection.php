<?php
/**
 * File: Collection.php
 * Created on Nov 30, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@advancewebsoft.com>
 */

class Model_User_Collection extends Model_Collection_Abstract {
	var $_currentUser;
	
	var $_table = 'users';
 	var $_id = 'id';
 	var $_model = 'User';
	function Model_User_Collection() {
		parent::__construct();
		$this->_core->getModel('User');
	}
	function getUser($id) {
//		if($this->size() == 0) {
 			$query = 'SELECT u.* ' .
 					'FROM `users` u ';
 			if($id && is_numeric($id)) {
 				$this->addFilter('id', $id, 'eq');
	 			if(sizeof($this->_filter)>0) {
	 				$query .= ' WHERE ' . $this->_core->getResource('DB')->getConnection()->getFilterSql($this);
	 			}
	 			if($this->_limit) {
	 				$query .= ' LIMIT ' . $this->_limit;
	 			}
	 			$this->_core->getResource('DB')->getConnection()->setQuery($query);
	 			$user = $this->_core->getResource('DB')->getConnection()->getResult('User');
	 			$user = $user[0];
 			}
// 		}
		return $user;
	}
	function getCurrentUser() {
		if(!isset($this->_currentUser) || !is_object($this->_currentUser) || !$this->_currentUser->get('id')) {
			if(isset($_SESSION['userid'])) {
				$this->_currentUser = $this->getUser($_SESSION['userid']);
			}
		}
		return $this->_currentUser;
	}
	function setCurrentUser($user) {
		if($user instanceof Model_User && $user->get('id')) {
			$this->_currentUser = $user;
		}
		return $user;
	}
}
?>