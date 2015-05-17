<?php
/**
 * Created on 19 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Error_Xml extends Block_Display {
 	var $_items;
 	function init() {
 		$this->_blockname = 'error';
 		$this->_items = $this->_core->getModel('Error/Collection')->getCollection();
 		$this->fetch('error', 'xml');
 		return $this;
 	}
 }