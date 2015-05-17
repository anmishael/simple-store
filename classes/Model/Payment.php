<?php
/**
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Model_Payment extends Model_Object {
	var $_table = 'payment';
	var $_id = 'id';
	function fetchVariables() {
		$this->push('variables', $this->_core->getModel('Payment/Variable/Collection')->newInstance()
					->addFilter('payment', $this->get($this->_id), 'eq')
					->getCollection($this->_core->getModel('Payment/Variable')->_id)
				);
		return $this;
	}
	function getModuleObject() {
 		return $this->_core->getModel('Payment/Collection')->getPaymentModule($this->get('name'));
 	}
}