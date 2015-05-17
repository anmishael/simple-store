<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Warning_Default extends Block_Display {
 	var $_items;
 	function init() {
 		$this->_blockname = 'warning';
 		$this->_items = $this->_core->getModel('Warning/Collection')->getCollection();
 		$this->fetch('warning', 'default');
 		return $this;
 	}
 }