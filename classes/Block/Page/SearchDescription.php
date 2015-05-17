<?php
/**
 * Created on 6 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Block_Page_SearchDescription extends Block_Display {
	var $_page;
	function init() {
		$this->_page = $this->_core->getModel('Page/Collection')->getCurrentPage();
		if(strlen(trim($this->_page->get('searchdescription')))>0) {
			$this->_blockname = 'searchdescription';
			$this->fetch('page', 'searchdescription');
		}
		return $this;
	}
}