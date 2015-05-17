<?php
/**
* Created on 25 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/

class Block_Warning_Json extends Block_Display {
	function init() {
 		$this->_blockname = 'warning';
 		$this->_items = $this->_core->getModel('Warning/Collection')->getCollection();
 		$this->fetch('warning', 'json');
		return $this;
	}
}