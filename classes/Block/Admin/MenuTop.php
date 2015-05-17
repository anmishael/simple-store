<?php
/*
 * Created on May 24, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Admin_MenuTop extends Block_Display {
 	var $_items = array();
 	function init() {
 		$this->_blockname = 'topmenu';
 		require_once('XML/Unserializer.php');
 		
 		/* Read config file and assign top menu {{ */
		$options = array(
				XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE=>true,
				XML_UNSERIALIZER_OPTION_ATTRIBUTES_ARRAYKEY=>true
			);
		$cfg = new XML_Unserializer($options);
		$cfg->unserialize('admin/configure.xml', true);
		$this->_core->configData = $cfg->getUnserializedData();
		$this->_items = array();
		$this->level = 0;
		$this->data = $this->_items;
//		echo '<table>';
		$this->setOutput($this->displayMainMenu($this->_core->configData['admin']['block']) . '<div class="clear"></div>');
//		echo '</table>';
		/* Read config file and assign top menu }} */
 		return $this;
 	}
 	function _prepareBlocks($data) {
 		$res = array();
 		foreach($data as $val) {
// 			echo print_r($val,1).'<br>';
 		}
 		return $res;
 	}
 	function displayMainMenu($data, $level = 0) {
 	 	$output = '<ul class="sf-menu">';
	 	foreach($data as $k=>$item) {
	 		$arr = array();
	 		if(isset($item['url'])) {
	 			$arr = explode('/', $item['url']);
	 		}
	 		if(sizeof($arr)>0) {
	 			$action = array_shift($arr);
	 			foreach($arr as $k=>$v) {
	 				$arr[$k] = trim(ucfirst($v));
	 			}
	 			$method = implode('', $arr);
	 		}
	 		if(!$action || $this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission($action, $method?$method:'actionIndex')) {
	 			$output2 = '';
		 		$output .= '<li>';
		 		$output .= '<a href="' . $this->_core->getSingleton('Config')->adminUrl . (isset($item['url'])?$item['url']:'') . '">' . $this->_core->getModel('Translate/Collection')->get($item['menuTitle'], 'value')->get('value') . '</a>';
		 		if(isset($item['block'])) {
		 			$bl = $item['block'];
		 			if(isset($bl['name'])) $bl = array($bl);
		 			$output2 .= $this->displayMainMenu($bl);
		 			
		 		}
		 		if($output2!='<ul class="sf-menu"></ul>') {
		 			$output .= $output2;
		 		}
		 		$output .= '</li>';
	 		}
	 	}
	 	$output .= '</ul>';
		return $output;
	 }
 }