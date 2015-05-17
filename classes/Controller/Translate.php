<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 04.04.13
 * Time: 2:50
 * To change this template use File | Settings | File Templates.
 */
class Controller_Translate extends Controller {
	function actionIndex() {

	}
	function actionList() {
		if($this->_core->doctype) {
			if(is_object($this->_core->getBlock('Translate/List/' . ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Translate/List/' . ucfirst($this->_core->doctype))->init();
			}
		}
	}
}
