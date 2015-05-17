<?php
/**
 * File: Collection.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

 class Model_Page_Collection extends Model_Collection_Abstract {
 	var $_table = 'pages';
 	var $_id = 'id';
 	var $_model = 'Page';
 	var $_table_desc = 'pages_description';
 	var $_table_desc_id = 'pdid';
 	var $_table_desc_conn_id = 'pid';
 	var $_page;
 	function getCurrentPage() {
 		if(!$this->_page instanceof Model_Page) {
 			$this->_page = $this->newInstance()
 				->addFilter('url', $this->_core->getUrl(), 'like')
 				->getOne(false,true,true);
 			if(!$this->_page instanceof Model_Page) {
 				$this->_page = $this->_core->getModel('Page')->newInstance();
 			}
 		}
 		return $this->_page;
 	}
 }