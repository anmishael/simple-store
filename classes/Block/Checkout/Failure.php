<?php
/**
 * Created on 17 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Block_Checkout_Failure extends Block_Display {
	function init() {
		$this->fetch('checkout', 'failure');
		return $this;
	}
}