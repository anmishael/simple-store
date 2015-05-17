<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class View {
	var $_output = array();
	var $_core;
	var $_prefolder = '';
	function __construct() {
		$this->_core = Core::getSingleton('Core');
		$this->templateDir = $this->_core->getSingleton('Config')->templateDir;
		$this->topFolder = $this->_core->getSingleton('Config')->topFolder;
		if(defined('CURRENT_FOLDER')) {
			$this->setFolder(CURRENT_FOLDER);
		}
	}
	function setFolder($path) {
		$this->_prefolder = $path;
		$this->templateDir .= $path;
		$this->topFolder .= $path;
		return $this;
	}
	function setOutput($key, $output, $id = false) {
		if(!isset($this->_output[$key])) {
			$this->_output[$key] = array();
			$this->_output[$key][] = array('output'=>$output, 'id'=>$id);
		} else {
			$this->_output[$key][sizeof($this->_output[$key])-1] = array('output'=>$output, 'id'=>$id);
		}
		return $this;
	}
	function addOutput($key, $output, $id = false,$searchForBlock=true) {
		if(!isset($this->_output[$key])) $this->_output[$key] = array();
		$this->_output[$key][] = array('output'=>$output, 'id'=>$id,'searchforblock'=>$searchForBlock);
// 		$this->_output[$key] = array_unique($this->_output[$key]);
		return $this;
	}
	function getOutput($key) {
		return isset($this->_output[$key])?$this->_output[$key]:false;
	}
	function displayBlock($key, $width_id = false, $searchForBlock = true) {
// 		die(print_r($this->_output,1));
		$output = $this->getOutput($key);
		if($width_id) {
			if(is_array($output)) {
				foreach($output as $k=>$val) {
					if(strlen(trim($val['output']))>0) {
						echo '<div id="' . $val['id'] . $k . '" class="block-box">' . ($searchForBlock && $val['searchforblock']?$this->searchForBlock($val['output']):$val['output']) . '</div>' . "\n";
					}
				}
			}
		} else {
			foreach($output as $k=>$val) {
				if(strlen(trim($val['output']))>0) {
					echo ($searchForBlock && $val['searchforblock']?$this->searchForBlock($val['output']):$val['output']);
				}
			}
		}
		return $this;
	}
	function getBlock($key, $width_id = false, $searchForBlock = true) {
		$output = $this->getOutput($key);
		$res = '';
		if($width_id) {
			if(is_array($output)) {
				foreach($output as $k=>$val) {
					if(strlen(trim($val['output']))>0) {
						$res .= '<div id="' . $val['id'] . $k . '" class="block-box">' . ($searchForBlock && $val['searchforblock']?$this->searchForBlock($val['output']):$val['output']) . '</div>' . "\n";
					}
				}
			}
		} else {
			foreach($output as $k=>$val) {
				if(strlen(trim($val['output']))>0) {
					$res .= ($searchForBlock && $val['searchforblock']?$this->searchForBlock($val['output']):$val['output']);
				}
			}
		}
		return $res;
	}
	function blockSize($key) {
		$output = $this->getOutput($key);
		$res = 0;
		if(is_array($output)) {
			foreach($output as $k=>$v) {
				if(strlen(trim($v['output']))>0) {
					$res++;
				}
			}
		} else {
			$res = strlen(trim($output));
		}
		return $res;
	}
	function displayOutput($searchForBlock = true) {
		if($this->_core->doctype) {
			$this->_core->getBlock('Error/' . ucfirst($this->_core->doctype))->init();
			$this->_core->getBlock('Warning/' . ucfirst($this->_core->doctype))->init();
		} else {
			$this->_core->getBlock('Error/Default')->init();
			$this->_core->getBlock('Warning/Default')->init();
		}
		ob_start();
		if($this->_core->doctype) {
			include($this->_core->getSingleton('Config')->getPath() . 'templates/' . $this->_core->getSingleton('Config')->getTemplate() . '/' . $this->_prefolder . 'pages/'.$this->_core->doctype.'.tpl.php');
		} else {
			require($this->_core->getSingleton('Config')->getPath() . 'templates/' . $this->_core->getSingleton('Config')->getTemplate() . '/' . $this->_prefolder . 'pages/default.tpl.php');
		}
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		return $this;
	}
	function searchForBlock($output) {
		preg_match_all("!{{block.*(.*)}}!U",$output,$arrBlocks,PREG_SET_ORDER);
		if(sizeof($arrBlocks)>0 && $arrBlocks[0][1]) {
			foreach($arrBlocks as $k=>$v) {
				$v[1] = str_replace('&quot;', '"', $v[1]);
				preg_match_all("!([a-zA-Z].*)=[\"'](.*)[\"']!U",$v[1],$data,PREG_SET_ORDER);
				$params = array();
				foreach($data as $x) {
					$params[$x[1]] = $x[2];
				}
				if(is_object($this->_core->getBlock($params['type']))) {
					$block = $this->_core->getBlock($params['type'])->setParams($params)->init();
					$output = str_replace($v[0], $block->getOutput(),$output);
					$output = $this->searchForBlock($output);
				}
			}
		}
		return $output;
	}
 }