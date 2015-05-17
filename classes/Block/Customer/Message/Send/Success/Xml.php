<?php
/**
 * Created on 7 серп. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Block_Customer_Message_Send_Success_Xml extends Block_Display {
 	function init() {
 		$this->_content = 'Your message was send successfully.';
		$this->fetch('customer', 'message/send/success/xml');
		return $this;
	}
 }