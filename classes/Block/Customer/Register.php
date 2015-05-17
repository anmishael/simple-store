<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Customer_Register extends Block_Display {
	var $_post;
	var $_cities;
	var $_states;
	var $_countries;
	function init() {
		$this->_post = $this->_core->getRequestPost();
		$this->fetch('customer','register');
		return $this;
	}
}