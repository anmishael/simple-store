<?php
/**
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Config {
 	var $DB = array();
 	function __construct() {
 		$this->setPath( Core::getFolder(__FILE__, 1) );
 		$p = $this->getUnixPath();
 		$this->setPath($p);
 		$this->topFolder = '/';
 		$this->siteUrl = $this->topFolder;
 		$this->adminUrl = $this->topFolder . 'admin/';
		if(defined('__PERMISSIONS__')) {
		  $this->_template = 'lt';
		} else {
		  $this->_template = 'lt';
		}
 		$this->templateDir = $this->topFolder . 'templates/' . $this->_template . '/';
 		$this->DB = array(
				'host'=>'localhost',
				'type'=>'MySQL',
				'name'=>'leotrade',
				'user'=>'root',
				'pass'=>''
			);
		$this->error_die = true;
		$this->js_pack = '';//'.min';
		$this->offline = true;
		$this->adminTmp = $this->getUnixPath() . 'admin/tmp/';
		$this->dbPath = '/var/www/ltqSxH/db/';
		$this->siteDomain = $_SERVER['HTTP_HOST'];
 	}
	function getPath() {
		return $this->path;
	}
	function getUnixPath() {
		if(!isset($this->unixPath)) {
			$path = $this->getPath();
			if(substr($path, 1, 1) == ':') {
				$path = substr($path, 2);
				$this->unixPath = str_replace('\'', '/', $path);
			} else {
				$this->unixPath = $path;
			}
		}
		return $this->unixPath;
	}
	function setPath($path) {
		$this->path = $path;
		return $this;
	}
	function getTemplate() {
		return $this->_template;
	}
 }
