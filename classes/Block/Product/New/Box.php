<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 26.03.13
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */

class Block_Product_New_Box extends Block_Display {
	var $_items;
	function init() {
		$this->_items = $this->_core->getModel()
	}
}