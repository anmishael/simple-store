<?php
/*
 * Created on May 25, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Page_Menu extends Model_Object {
 	var $_pages;
 	function getPages($parent = null) {
 		if($this->get('id')) {
 			$query = 'SELECT p.*, pd.* FROM `pages` p LEFT JOIN (`pages_description` pd) ON (pd.pid=p.id AND pd.language='.(int)$this->_core->getModel('Language/Collection')->getCurrentLanguage()->get('id').'), `pages_to_menus` pm WHERE '.($parent!==null?' p.parent='.$parent.' AND ':'').' p.id=pm.page AND pm.menu=\''.$this->get('id').'\' ORDER BY pm.sortorder';
 			$this->_pages = $this->_core->getResource('DB')->getConnection()->setQuery($query)->getResult('Page');
 		}
 		return $this->_pages;
 	}
 }