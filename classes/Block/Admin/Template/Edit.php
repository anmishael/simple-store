<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Template_Edit extends Block_Display {
 	var $_item;
 	var $_languages;
 	function init() {
 		$this->_core->getModel('Template');
 		$this->_languages = $this->_core->getModel('Language/Collection')->getAllLanguages();
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('Template/Collection')->newInstance()
 					->addFilter('id', $this->_core->getRequest('id'), 'eq')
 					->getOne();
 			if(!is_object($this->_item) || !$this->_item instanceof Model_Template) {
 				$this->_item = $this->_core->getModel('Template')->newInstance();
 			}
 		} else {
 			$this->_item = $this->_core->getModel('Template')->newInstance();
 		}
 		$this->_item->fetchDescription();
 		$this->fetch('template', 'edit');
 		return $this;
 	}
 }