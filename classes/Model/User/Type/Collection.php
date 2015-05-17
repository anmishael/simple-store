<?php
/**
 * File: Collection.php
 * Created on Dec 4, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@advancewebsoft.com>
 */

class Model_User_Type_Collection extends Model_Collection_Abstract {
	var $_table = 'user_types';
 	var $_id = 'id';
 	var $_model = 'User/Type';
	function getUserType($id) {
		$this->_core->getModel('User/Type');
		$query = 'SELECT ut.* FROM `user_types` ut WHERE ut.id=\'' . $id . '\'';
		$res = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult('User/Type');
		if(isset($res[0])) {
			$res = $res[0];
			if($res->get('permissions')) {
				$res->set('permissions', unserialize($res->get('permissions')));
			}
		} else {
			$res = new Model_User_Type();
		}
		return $res;
	}
}
?>