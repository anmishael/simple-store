<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Block_Admin_Filter_Type_Edit extends Block_Display {
 	var $_item;
 	var $_languages;
 	function init() {
 		$this->_languages = $this->_core->getModel('Language/Collection')->getCollection();
 		$this->_item = $this->_core->getModel('Filter/Type/Collection')
 				->newInstance()
 				->addFilter('id', $this->_core->getRequest('id'), 'eq')
 				->getOne();
 		if(!$this->_item instanceof Model_Filter_Type) $this->_item = $this->_core->getModel('Filter/Type')->newInstance(array('id'=>null, 'name'=>null, 'url'=>null, 'usecolumn'=>null, 'function'=>null, 'status'=>null));
 		$this->_item->fetchDescription();
 		
 		$this->fetch('filter', 'type/edit');
 		return $this;
 	}
 }