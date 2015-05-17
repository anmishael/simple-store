<?php
/**
 * Created on 27 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Block_Setting_List_Xml extends Block_Display {
	var $_items;
	function init() {
		$this->_items = $this->_core->getModel('Setting/Collection')->newInstance()
				->addFilter('public', 1, 'eq')
				->getCollection();
		$this->fetch('setting', 'list/xml');
		return $this;
	}
}