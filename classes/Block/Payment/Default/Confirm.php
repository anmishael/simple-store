<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Block_Payment_Default_Confirm extends Block_Display {
	var $_params;
	function init() {
		$this->fetch('payment', 'default/confirm');
		return $this;
	}
}