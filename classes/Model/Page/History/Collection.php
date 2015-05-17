<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Model_Page_History_Collection extends Model_Collection_Abstract {
	var $_size = 5;
	function __construct() {
		parent::__construct();
		$this->_collection = $_SESSION['history'];
		if($this->size()>0) {
			$this->_collection = array_chunk($this->_collection, $this->_size);
			$this->_collection = array_unique($this->_collection[0]);
		}
	}
	function push($page) {
		if($page instanceof Model_Page) {
			array_unshift($this->_collection, $this->_core->getModel('Page/History')->newInstance(array('id'=>$page->get('id'), 'url'=>$page->get('url'))));
			$this->save();
		}
		return $this;
	}
	function getCollection() {
		return $this->_collection;
	}
	function save() {
		$_SESSION['history'] = array_unique($this->toArray());
	}
}