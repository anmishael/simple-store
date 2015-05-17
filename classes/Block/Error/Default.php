<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Error_Default extends Block_Display {
	var $_items;
	function init() {
		$this->_blockname = 'error';
		$this->_items = $this->_core->getModel('Error/Collection')->getCollection();
		$this->fetch('error', 'default');
		return $this;
	}
}