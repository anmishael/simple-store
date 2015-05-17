<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Display extends Block {
	var $_limit = 25;
	var $_page = 1;
	var $_totalpages = 1;
	var $_toplinks = array();
	var $_actions = array();
	var $_perpage = array();
	 var $_arrLimit = array(10, 20, 50, 100, 500, 1000);
	function __construct() {
		parent::__construct();
		$this->_page = (is_numeric($this->_core->getRequest('_p')) && $this->_core->getRequest('_p')>0) ? $this->_core->getRequest('_p') : 1;

		$this->_perpage = array(10, 25, 50, 250, 1000);
		if($_SESSION['_limit']) {
			$this->_limit = $_SESSION['_limit'];
		}
		if($this->_core->getRequestPost('_limit')>0) {
			$this->_limit = $this->_core->getRequest('_limit');
			$_SESSION['_limit'] = $this->_limit;
			$_ra = explode('?', $_SERVER['REQUEST_URI']);
			$this->_core->redirect($_ra[0] . '?' . $this->_core->getAllGetParams(array('_p', '_limit')));
		}
	}
	function init() {
		return $this;
	}
	function setTotal($total) {
		$this->_total = $total;
		return $this;
	}
	function setCurrent($current) {
		$this->_current = $current;
		return $this;
	}
	function setLimit($limit) {
		$this->_limit = $limit;
		return $this;
	}
	function getOutput() {
 
		return parent::getOutput();
	}
}