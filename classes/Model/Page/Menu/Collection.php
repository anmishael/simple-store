<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Page_Menu_Collection extends Model_Collection_Abstract {
 	var $_table = 'menus';
 	var $_is = 'id';
 	var $_model = 'Page/Menu';
//  	function getCollection() {
//  		$query = 'SELECT m.* FROM `menus` m ';
//  		if(sizeof($this->_filter)>0) {
//  			$query .= ' WHERE ' . $this->_core->getResource('DB')->getConnection()->getFilterSql($this);
//  		}
//  		$this->_collection = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult('Page/Menu');
//  		return $this->_collection;
//  	}
 }