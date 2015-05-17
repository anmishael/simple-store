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
class Block {
	var $_output = '';
	var $_params = array('pagination'=>true, 'sortbar'=>true);
	var $_core;
	var $_blockname = 'content';
	var $_block_id;
	var $_prefolder = '';
	function __construct() {
		$this->_core = Core::getSingleton('Core');
		$this->_block_id = strtolower(get_class($this));
		$this->templateDir = $this->_core->getSingleton('Config')->templateDir;
 		$this->topFolder = $this->_core->getSingleton('Config')->topFolder;
 		if(defined('CURRENT_FOLDER')) {
 			$this->setFolder(CURRENT_FOLDER);
 		}
	}
	function newInstance($args = null) {
 		return $this->_core->newInstance($this, $args);
 	}
 	function push($name, $val) {
 		$this->$name = $val;
 		return $this;
 	}
 	function setFolder($path) {
 		$this->_prefolder = $path;
 		$this->templateDir .= $path;
 		$this->topFolder .= $path;
 		return $this;
 	}
	function getOutput() {
//		$this->searchForBlock();
		$output = $this->_output;
		$this->_output = '';
		return $output;
	}
	function setOutput($output, $searchForBlock = true) {
		$this->_output = $output;
//		if($searchForBlock) $this->searchForBlock();
		$this->_core->getSingleton('View')->setOutput($this->_blockname, $this->_output, $this->_block_id, $searchForBlock);
		return $this;
	}
	function addOutput($output, $searchForBlock = true) {
		$this->_output = $output;
//		if($searchForBlock) $this->searchForBlock();
//		echo get_class($this) . ' '.$this->_blockname . "\n".'<br />';
		$this->_core->getSingleton('View')->addOutput($this->_blockname, $this->_output, $this->_block_id, $searchForBlock);
//		$this->_output = '';
		return $this;
	}
	function apply($block, $name) {
		ob_start();
		include($this->_core->getSingleton('Config')->getPath() . $this->templateDir . 'pages/' . $block . '/' . $name . '.tpl.php');
		$_output = ob_get_contents();
		ob_end_clean();
		return $_output;
	}
	function fetch($block, $name, $searchForBlock = true, $fetchonly = false) {
		ob_start();
		include($this->_core->getSingleton('Config')->getPath() . $this->templateDir . 'pages/' . $block . '/' . $name . '.tpl.php');
		$_output = ob_get_contents();
		ob_end_clean();
//		echo get_class($this) . ' '.$this->_blockname . '<br />';
		if(!$fetchonly) {
			return $this->addOutput( $_output, $searchForBlock );
		} else {
			return $_output;
		}
	}
	function fetchjs($block, $name, $searchForBlock = true, $raw = false) {
		if($raw) {
			$_output = $name;
		} else {
			$_output = '<script type="text/javascript" src="'.$this->templateDir . 'js/pages/' . $block . '/' . $name . $this->_core->getSingleton('Config')->js_pack . '.js"></script>';
		}
		$this->_core->getSingleton('View')->addOutput('javascript', $_output, false, false);
		return $this;
	}
	function setParams($params) {
		$this->_params = array_merge($this->_params, $params);
		return $this;
	}
	function setParam($key, $val) {
		$this->_params[$key] = $val;
		return $this;
	}
	function getParam($key) {
		return $this->_params[$key];
	}
	function getParams() {
		return $this->_params;
	}
	function searchForBlock() {
		preg_match_all("!{{block.*(.*)}}!U",$this->_output,$arrBlocks,PREG_SET_ORDER);
		if(sizeof($arrBlocks)>0 && $arrBlocks[0][1]) {
			foreach($arrBlocks as $k=>$v) {
				$v[1] = str_replace('&quot;', '"', $v[1]);
				preg_match_all("!([a-zA-Z].*)=[\"'](.*)[\"']!U",$v[1],$data,PREG_SET_ORDER);
				$params = array();
				foreach($data as $x) {
					$params[$x[1]] = $x[2];
				}
				if(is_object($this->_core->getBlock($params['type']))) {
					$this->_core->getBlock($params['type'])->setParams($params)->init();
					$this->_output = str_replace($v[0], $this->_core->getBlock($params['type'])->getOutput(),$this->_output);
					$this->searchForBlock();
				}
				
			}
		}
		return $this;
	}
}