<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */

class Block_Admin_Language_Edit extends Block_Display {
	var $_item;
	function init() {
		if($this->_core->getRequest('id')) {
			$this->_item = $this->_core->getModel('Language/Collection')->newInstance()
					->addFilter('id', $this->_core->getRequest('id'), 'eq')
					->getOne();
		}
		if(!$this->_item instanceof Model_Language || !$this->_item->Get('id')) {
			$this->_item = $this->_core->getModel('Language/Collection')->newInstance();
		}
		$this->fetch('language', 'edit');
		return $this;
	}
}