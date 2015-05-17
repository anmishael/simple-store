<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Customer_Register_Success_Xml extends Block_Display {
 	var $_content;
 	function init() {
 		$this->_blockname = 'content';
 		$this->_content = $this->_core->getModel('Translate/Collection')->get('CUSTOMER_REGISTER_SUCCESS')->get('value');
 		$this->fetch('customer', 'register/success/xml');
 		return $this;
 	}
 }