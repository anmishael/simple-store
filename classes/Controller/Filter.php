<?php
/**
* Created on 12 ���. 2012
* By Mikel Annjuk <anmishael@gmail.com>
* Especially for KinetoscopeMedia Inc.
*/
class Controller_Filter extends Controller {
	function actionIndex() {
		
	}
	function actionList() {
		if($this->_core->doctype) {
 			$this->_core->getBlock('Filter/List/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Filter/List')->init();
 		}
	}
}