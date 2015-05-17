<?php
/**
* Created on 18 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/

class Block_Page_ContentLeft extends Block_Display {
	var $_page;
	function init() {
		$this->_page = $this->_core->getModel('Page/Collection')->getCurrentPage();
		if(strlen(trim($this->_page->get('content_left')))>0) {
			$this->_blockname = 'contentleft';
			$this->fetch('page', 'contentleft');
		}
		return $this;
	}
}