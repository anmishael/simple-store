<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_State_City_Edit extends Block_Display {
 	var $_item;
 	var $_states;
 	var $_weights = array('Small', 'Medium', 'Large');
 	function init() {
 		$this->_states = $this->_core->getModel('State/Collection')->clear()->getCollection();
 		$this->_item = $this->_core->getModel('State/City/Collection')->clear()->addFilter('id', $this->_core->getRequest('id'), 'eq')->getCollection();
 		if($this->_item[0]) $this->_item = $this->_item[0];
 		else $this->_item = new Model_State_City();
 		$this->fetch('state', 'city/edit');
 	}
 }