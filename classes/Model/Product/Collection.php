<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Model_Product_Collection extends Model_Collection_Abstract {
 	var $_table = 'products';
 	var $_model = 'Product';
 	var $_id = 'id';
 	var $_table_desc = 'products_description';
 	var $_table_desc_id = 'pdid';
 	var $_table_desc_conn_id = 'pid';

 	function getImages($objProd) {
 		$images = array();
 		if(is_object($objProd) && $objProd->get('id')) {
 			$query = 'SELECT i.* FROM `images` i WHERE i.pid = \''. ($objProd->get('id')) .'\' ORDER BY `default` DESC';
 			$this->_core->getResource('DB')->getConnection()->setQuery($query);
 			$images = $this->_core->getResource('DB')->getConnection()->getResult();
 		}
 		return $images;
 	}
 	function getVideos($objProd) {
 		$videos = array();
 		if(is_object($objProd) && $objProd->get('id')) {
 			$query = 'SELECT i.* FROM `videos` i WHERE i.pid = \''. ($objProd->get('id')) .'\' ORDER BY `sortorder` DESC';
 			$this->_core->getResource('DB')->getConnection()->setQuery($query);
 			$videos = $this->_core->getResource('DB')->getConnection()->getResult();
 		}
 		return $videos;
 	}
 }