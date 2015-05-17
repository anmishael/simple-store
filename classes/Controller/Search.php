<?php
/**
 * Created on 22 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Controller_Search extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareurls();
	}
	function actionIndex() {
		$this->_core->getBlock('Search/List')->init();
	}
	function actionList() {
		
	}
	function prepareUrls() {
 		$this->pushUrl('search-list', $this->_siteUrl . 'search/list');
 		return $this;
 	}
}