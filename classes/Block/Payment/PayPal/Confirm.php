<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Payment_PayPal_Confirm extends Block_Display {
	var $_params;
	function init() {
		$this->fetch('payment', 'paypal/confirm');
		return $this;
	}
}