<?php
/**
 * Created on 27 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Controller_Setting extends Controller {
 	function actionIndex() {
 		
 	}
 	function actionList() {
 		if($this->_core->doctype) {
 			$this->_core->getBlock('Setting/List/' . ucfirst($this->_core->doctype))->init();
 		} else {
 			$this->_core->getBlock('Setting/List')->init();
 		}
 	}
 }