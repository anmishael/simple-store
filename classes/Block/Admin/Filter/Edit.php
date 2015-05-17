<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
 
 class Block_Admin_Filter_Edit extends Block_Display {
 	var $_item;
 	var $_types;
 	var $_languages;
 	function init() {
 		$this->_languages = $this->_core->getModel('Language/Collection')->getCollection();
 		$this->_item = $this->_core->getModel('Filter/Collection')
 				->clear()
 				->addFilter('id', $this->_core->getRequest('id'), 'eq')
 				->getOne();
 		$this->_types = $this->_core->getModel('Filter/Type/Collection')->clear()->getCollection(false, true, true);
 		if(!$this->_item instanceof Model_Filter) {
			$this->_item = $this->_core->getModel('Filter')->newInstance();
 		}
 		
 		$this->_item->fetchDescription();
 		
 		$this->fetch('filter', 'edit');
 		return $this;
 	}
 }