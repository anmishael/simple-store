<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Controller_Index extends Controller {
 	function actionIndex() {
 		if(!($page = $this->_core->getModel('Page/Collection')->getCurrentPage()) instanceof Model_Page || !$page->get('id')) {
			$url = trim(str_replace('/', ' ', $this->_core->getUrl()));
			$this->_core->redirect($this->_core->getSingleton('Config')->topFolder . 'search?search='.$url);
 		}
 	}
 }