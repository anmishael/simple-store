<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

/**
 * @property Core $_core
 */

class Controller {
	var $actionUrls;
	var $arrControllers = array();
	var $_root;
	var $_core = Core;
	var $_adminUrl;
	var $_siteUrl;
	var $controllerName = '';
 	function __construct() {
 		$this->_core = Core::getSingleton('Core');
 		$this->_adminUrl = $this->_core->getSingleton('Config')->adminUrl;
 		$this->_siteUrl = $this->_core->getSingleton('Config')->siteUrl;
 	}
	function init() {
		return $this;
	}
	function pushUrl($key, $val) {
		if($key && $val) {
			if(strlen($this->_core->controllerName)>0) {
				$arrUrl = explode('/', stristr($val, $this->_core->controllerName));
			} else {
				$arrUrl = array();
			}
			$controller = array_shift($arrUrl);
			$method = '';
			foreach($arrUrl as $name) {
				$method .= ucfirst($name);
			}
			$this->actionUrls[$key] = $val;
			$this->_core->assign('actionUrls', $this->actionUrls);
		}
	}
	function getActionUrl($key) {
		return $this->actionUrls[$key];
	}
	function getAllControllers($place = '') {
		if(sizeof($this->arrControllers)==0) {
			$loc = Core::getSingleton('Config')->getPath() . 'classes/Controller/' . (strlen($place)>0?$place . '/':'');
			if(file_exists($loc)) {
				$d = dir($loc);
				$pref = 'action';
				$prefLen = strlen($pref);
				$mExclude = array('Index');
				$cExclude = array('Index');
				while(false !== ($file = $d->read())) {
					if(is_file($loc . $file)) {
						$fPath = pathinfo($file);
						if(!isset($fPath['filename'])) {
							$fPath['filename'] = $fPath['basename'];
							if(stristr($fPath['filename'], '.')) {
							  $fPath['filename'] = explode('.', $fPath['filename']);
							  array_pop($fPath['filename']);
							  $fPath['filename'] = implode('.',$fPath['filename']);
							}
						}
						if(!in_array($fPath['filename'], $cExclude)) {
							$this->arrControllers[$fPath['filename']] = array();
							$cName = 'Controller_' . (strlen($place)>0?$place . '_':'') .$fPath['filename'];
							require_once($loc . $file);
							
							$arrMethods = get_class_methods(new $cName);
							foreach($arrMethods as $mName) {
								if(substr($mName, 0, $prefLen)==$pref && !in_array(substr($mName, $prefLen), $mExclude)) {
									$this->arrControllers[$fPath['filename']][substr($mName, $prefLen)] = 1;
								}
							}
						}
					}
				}
			}
		}
		return $this->arrControllers;
	}
}