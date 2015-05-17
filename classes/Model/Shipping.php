<?php
/*
 * Created on 18 Вер 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Model_Shipping extends Model_Object {
 	var $_shipping;
 	var $_table = 'shipping';
 	var $_id = 'id';
 	function __construct($data) {
 		parent::__construct($data);
 		$this->setData($data);
 	}
 	function setData($data) {
 		parent::setData($data);
 		$this->_shipping = $data;
 	}
 	function getId() {
 		return $this->_shipping['name'];
 	}
 	function getName() {
 		return $this->_shipping['name'];
 	}
 	function getAmount() {
 		return $this->_shipping['amount'];
 	}
 	function getLabel() {
 		return $this->_shipping['label'];
 	}
 	function toArray() {
 		return $this->_shipping;
 	}
 	function setShipping($name) {
 		$this->setData($this->_core->getModel('Shipping/Collection')->newInstance()
 				->addFilter('name', $name, 'eq')
 				->getOne());
 		return $this;
 	}
 }
?>