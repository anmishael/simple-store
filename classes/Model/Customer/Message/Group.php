<?php
/**
 * Created on 7 серп. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Model_Customer_Message_Group extends Model_Object {
 	var $_table = 'customer_message_groups';
 	var $_model = 'Model_Customer_Message_Group';
 	var $_id = 'id';
 	var $_parents = array();
 	function fetchMessages() {
 		$this->push('messages', $this->_core->getModel('Customer/Message/Collection')->newInstance()
 				->addFilter('mgid', $this->get('id'), 'eq')
 				->addField('DATE_FORMAT(added, "%c/%e/%y") as added_date')
 				->addField('DATE_FORMAT(added, "%l/%i") as added_time')
 				->setOrder('added')
 				->setOrderWay('asc')
 				->getCollection('id'));
 		return $this;
 	}
 	function fillParents() {
 		$_msgs = $this->get('messages');
 		foreach($_msgs as $k=>$val) {
 			if(!isset($this->_parents[$val->get('parent')])) $this->_parents[$val->get('parent')] = array();
 			$this->_parents[$val->get('parent')][] = $val->get('id');
 		}
 		return $this;
 	}
 	function getLastMessage() {
 		$last = null;
 		$_msgs = $this->get('messages');
 		$_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
 		foreach($_msgs as $k=>$val) {
 			if($_msgs[$k]->get('sender')!=$_customer->get('id')) {
				$last = $_msgs[$k];
			}
 		}
		return $last;
 	}
 	function remove() {
 		$_messages = $this->_core->getModel('Customer/Message/Collection')->newInstance()
 				->addFilter('mgid', $this->get('id'), 'eq')
 				->getCollection();
 		foreach($_messages as $_message) {
 			$_message->remove();
 		}
 		parent::remove();
 		return $this;
 	}
 }