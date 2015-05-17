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

class Model_Customer_Type_Collection extends Model_Collection_Abstract {
	var $_table = 'customer_types';
 	var $_id = 'id';
 	var $_model = 'Customer/Type';
	function getCustomerType($id) {
		$this->_core->getModel('Customer/Type');
		$query = 'SELECT ct.* FROM `customer_types` ct WHERE ct.id=\'' . $id . '\'';
		$res = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult('Customer/Type');
		if(isset($res[0])) {
			$res = $res[0];
			if($res->get('permissions')) {
				$res->set('permissions', unserialize($res->get('permissions')));
			}
		} else {
			$res = new Model_Customer_Type();
		}
		return $res;
	}
}
?>