<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Admin_Currency_Edit extends Block_Display {
	var $_item;
	function init() {
		$this->_item = $this->_core->getModel('Currency/Collection')
 				->newInstance()
 				->addFilter('id', $this->_core->getRequest('id'), 'eq')
 				->getOne();
 		if(!$this->_item instanceof Model_Currency) {
 			$this->_item = $this->_core->getModel('Currency')->newInstance();
 		}
 		$this->fetch('currency', 'edit');
		return $this;
	}
}