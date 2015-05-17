<?php
/**
 * Created on 19 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Setting_Edit extends Block_Display {
 	var $_item;
 	function init() {
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('Setting/Collection')->newInstance()
 					->addFilter('id', $this->_core->getRequest('id'), 'eq')
 					->getOne();
 			if(!is_object($this->_item) || !$this->_item instanceof Model_Setting) {
 				$this->_item = $this->_core->getModel('Setting')->newInstance();
 			}
 		} else {
 			$this->_item = $this->_core->getModel('Setting')->newInstance();
 		}
 		$this->fetch('setting', 'edit');
 		return $this;
 	}
 }