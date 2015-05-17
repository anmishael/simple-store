<?php
/**
 * Created on 17 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @version 1.0
 */
 
class Block_Language_Bar extends Block_Display {
	var $_items;
	function init() {
		$this->_blockname = 'languagebar';
		$this->_items = $this->_core->getModel('Language/Collection')->newInstance()
				->addFilter('status', 1, 'eq')
				->getCollection();
		$this->fetch('language', 'bar');
		return $this;
	}
}