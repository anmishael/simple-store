<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Block_Admin_Translate_Edit extends Block_Display {
 	var $_item;
 	var $_languages;
 	function init() {
 		$this->_languages = $this->_core->getModel('Language/Collection')->getCollection($this->_core->getModel('Language')->_id);
 		if($this->_core->getRequest('id')) {
 			$this->_item = $this->_core->getModel('Translate/Collection')->newInstance()
 					->addFilter($this->_core->getModel('Translate')->_id, $this->_core->getRequest('id'), 'eq')
 					->getOne();
 			if(!is_object($this->_item) || !$this->_item instanceof Model_Translate) {
 				$this->_item = $this->_core->getModel('Translate')->newInstance();
 			}
 		} else {
 			$this->_item = $this->_core->getModel('Translate')->newInstance();
 		}
 		$this->fetch('translate', 'edit');
 		return $this;
 	}
 }