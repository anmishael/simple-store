<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Model_Warning_Collection extends Model_Collection_Abstract {
 	function __construct() {
 		parent::__construct();
 		if(isset($_SESSION['warnings'])) {
 			$arr = unserialize($_SESSION['warnings']);
 			foreach($arr as $k=>$v) {
 				if(strlen(trim($v['content']))>0) {
 					$this->put($this->_core->getModel('Warning')->newInstance(array('title'=>$v['title'], 'content'=>$v['content'])));
 				}
 			}
 			unset($_SESSION['warnings']);
 		}
 		unset($_SESSION['warnings']);
 	}
 	function getCollection() {
 		return $this->_collection;
 	}
 	function pushToSession() {
 		$_SESSION['warnings'] = serialize($this->toArray());
 	}
 }