<?php
/**
 * File: User.php
 * Created on Nov 30, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@advancewebsoft.com>
 */

class Model_User extends Model_Object {
	var $_table = 'users';
	var $_id = 'id';
	var $_model = 'User';
	function getUsername() {
		return $this->_data['username'];
	}
	function getEmail() {
		return $this->_data['email'];
	}
	function getFirstName() {
		return $this->_data['name_first'];
	}
	function getLastName() {
		return $this->_data['name_last'];
	}
	function getPassword() {
		return $this->_data['password'];
	}
	function getUserType() {
		return $this->_data['typeid'];
	}
	function authorize($username, $password) {
		$query = 'SELECT * FROM `users` u WHERE u.username=\'' . addslashes($username) . '\' AND u.password=\'' . addslashes($this->generatePassword($password)) . '\' LIMIT 1';
		$res = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();
		if(isset($res[0]['id'])) {
			$this->setData($res[0]);
		}
		return $this;
	}
	function save() {
		if($this->get('password') && $this->get('password_confirm')) {
			if($this->get('password') != $this->get('password_confirm')) {
				$this->_core->raiseError('Password confirm did not mutch password.');
			} else {
				$this->set('password', $this->generatePassword($this->get('password')));
			}
		} else {
			$this->pop('password');
		}
		$data = $this->toArray();
		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('users');
 		foreach($data as $k=>$v) {
 			if(!in_array($k, $columns)) unset($data[$k]);
 		}
		/*
		if($this->get('id')) {
 			$pc = $this->_core->getModel('User/Type/Collection')->newInstance();
 			$pc->addFilter('id', $this->get('id'), 'eq');
 			$res = $this->_core->getResource('DB')->getConnection()->update('users', $data, $pc);
 		} else {
 			$res = $this->_core->getResource('DB')->getConnection()->insert('users', $data);
 		}
		//*/

 		return parent::save();
	}
	function generatePassword($pass) {
		return md5($pass);
	}
	function checkPermission($action, $method) {
		$action = ucfirst($action);
		$strlen = strlen('action');
		if(substr($method, 0, $strlen) == 'action') {
			$method = substr($method, strlen('action'));
		}
		$res = false;
		if($this->getUserType()==1) {
			$res = true;
		} else {
			if(!$this->get('permissions')) {
				$this->_core->getModel('User/Type/Collection');
				$coll = new Model_User_Type_Collection();
				$this->set('permissions', $coll->getUserType($this->getUserType())->getPermissions());
			}
			$arrPerm = $this->get('permissions');
			if((isset($arrPerm[$action]) || $action == 'Index') && (isset($arrPerm[$action][$method]) || $method=='Index')) {
				$res = true;
			}
		}
		return $res;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	}
}
?>