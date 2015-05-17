<?php
/*
 * Created on 25 Кві 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Model_Payment_Collection extends Model_Collection_Abstract {
 	var $_table = 'payment';
 	var $_id = 'id';
 	var $_model = 'Payment';
 	function getCollection() {
 		parent::getCollection();
 		foreach($this->_collection as $k=>$v) {
 			$this->_collection[$k]->fetchVariables();
 		}
 		return $this->_collection;
 	}
 	
	function getAllPaymentModules($exclude = array()) {
		foreach($exclude as $k=>$v) {
			$exclude[$k] = strtolower(trim($v));
		}
		reset($exclude);
		$path = $this->_core->getSingleton('Config')->path . '/classes/Model/Payment/Module/';
		$arrModules = array();
		if ($handle = opendir($path)) {
		    /* This is the correct way to loop over the directory. */
		    while (false !== ($file = readdir($handle))) {
		    	$cfgFile = $path . $file . '/config.xml';
		        if(is_dir($path . $file) && $file !='..' && file_exists($cfgFile) && !in_array(strtolower(trim($file)), $exclude)) {
		        	$this->_core->getSingleton(new XML_Unserializer())->unserialize($cfgFile, true);
					$arrData = $this->_core->getSingleton('XML_Unserializer')->getUnserializedData();
		        	$arrModules[] = array(
		        			'file'=>$file,
		        			'config'=>$arrData
		        		);
		        }
		    }
		    closedir($handle);
		}
		return $arrModules;
	}
	
 	function getPaymentModule($name) {
 		$path = $this->_core->getSingleton('Config')->getUnixPath() . '/classes/Model/Payment/Module/' . $name;
		$cfgFile = $path . '/config.xml';
		$arrData = array();
		if(file_exists($cfgFile)) {
			require_once('XML/Unserializer.php');
			$xml = new XML_Unserializer();
			$this->_core->getSingleton($xml);
			$this->_core->getSingleton('XML_Unserializer')->unserialize($cfgFile, true);
			$arrData = $this->_core->getSingleton('XML_Unserializer')->getUnserializedData();
		}
		return $arrData;
 	}
 	
	function getControllerMethods($cName, $module) {
		$arrCfg = $this->getPaymentModule($module);
		if(!empty($arrCfg['controller']['action']) && !$arrCfg['controller']['action'][0]) {
			$arrCfg['controller']['action'] = array($arrCfg['controller']['action']);
		}
		foreach($arrCfg['controller']['action'] as $method) {
			if($method['name'] == $cName) {
				if($method['class'] && $method['class']['classname'] && is_object($this->_core->getSingleton($method['class']['classname']))) {
					if(!empty($method['class']['method']) && !$method['class']['method'][0]) {
						$method['class']['method'] = array($method['class']['method']);
					}
					foreach($method['class']['method'] as $k=>$v) {
						if($v['attribute'] && !$v['attribute'][0]) {
							$method['class']['method'][$k]['attribute'] = array($v['attribute']);
						}
					}
					return $method;
				}
				break;
			}
		}
		return false;
	}
	
	function getPaymentModules() {
		
	}
 }
?>