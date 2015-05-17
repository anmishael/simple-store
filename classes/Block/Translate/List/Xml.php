<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 04.04.13
 * Time: 2:53
 * To change this template use File | Settings | File Templates.
 */
class Block_Translate_List_Xml extends Block_Display {
	var $_items;
	function init() {
		$this->_items = $this->_core->getModel('Translate/Collection')->getCollection(false, true, true);
		$this->fetch('translate', 'list/xml');
	}
}
