<?php
/**
 * File: Type.php
 * Created on Dec 4, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@advancewebsoft.com>
 */

class Model_User_Type extends Model_Object {
	function getId() {
		return $this->_data['id'];
	}
	function getName() {
		return $this->_data['name'];
	}
	function getPermissions() {
		if($this->get('permissions') && !is_array($this->get('permissions'))) {
			$this->set('permissions', unserialize($this->get('permissions')));
		}
		return $this->get('permissions');
	}
	function save() {
 		$res = false;
 		
 		$columns = $this->_core->getResource('DB')->getConnection()->getTableColumns('user_types');
 		$data = $this->_data;
 		foreach($data as $k=>$v) {
 			if(!in_array($k, $columns)) unset($data[$k]);
 		}
 		if($data['permissions'] && is_array($data['permissions'])) {
 			$data['permissions'] = serialize($data['permissions']);
 		}
 		if($this->get('id')) {
 			$this->_core->getModel('User/Type/Collection');
 			$pc = new Model_User_Type_Collection();
 			$pc->addFilter('id', $this->get('id'), 'eq');
 			$res = $this->_core->getResource('DB')->getConnection()->update('user_types', $data, $pc);
 		} else {
 			$res = $this->_core->getResource('DB')->getConnection()->insert('user_types', $data);
 		}
 		return $res;
 	}
 	function remove() {
 		$query = 'DELETE FROM `user_types` WHERE id=\'' . $this->get('id') . '\'';
 		$this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult();
 		return $this;
 	}
}
?>