<?php
/**
 * Created on May 18, 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', true);
$loc = pathinfo(__FILE__);
$loc = explode('\\', $loc['dirname']);

$loc = '/'. implode('/', $loc) . '/';

set_include_path($loc . PATH_SEPARATOR . './classes/3rdparty/PEAR/'.PATH_SEPARATOR.'./classes/3rdparty/');

session_start();
require('classes/Core.php');

Core::getSingleton('Config');

include('includes/events.php');

$objCore = Core::getSingleton('Core');
$objCore->getSingleton('Controller');
$objCore->getResource('DB/Abstract');
$objCore->getResource('DB');
$objCore->getModel('Object');
$objCore->getModel('Collection/Abstract');
$objCore->getSingleton('Block');
$objCore->getBlock('Display');
ob_start();
$arrUrl = explode('/', $objCore->getUrl());
if(!$objCore->notNull(trim($arrUrl[0]))) {
	array_shift($arrUrl);
}

$objCore->getModel('Setting/Collection')->getCollection('key');
$objCore->getModel('Language/Collection')->fetchLanguage();
$objCore->getModel('Translate/Collection')->addFilter('language', $objCore->getModel('Language/Collection')->getCurrentLanguage()->get($objCore->getModel('Language')->_id), 'eq')->getCollection('key');

$controller = array_shift($arrUrl);

if(!is_object($objCore->getSingleton('Controller/'.ucfirst($controller)))) {
	$controller = 'Index';
}

if(is_object(Core::getSingleton('Controller/'.ucfirst($controller)))) {
	$objCore->controllerUrl = $objCore->getSingleton('Config')->siteUrl . $controller;
	$objCore->controllerName = $controller;
	
	$action = 'Index';
	if(sizeof($arrUrl)>0) {
		$action = '';
		foreach($arrUrl as $val) {
			if(!$objCore->controllerTopAction) {
				$objCore->controllerTopAction = ucfirst($val);
			}
			$action .= ucfirst($val);
		}
		if(!method_exists($objCore->getSingleton('Controller/'.ucfirst($controller)), 'action' . $action)) {
			$action = 'Index';
		}
	}
	$objCore->controllerAction = $action;
	$method = 'action' . $action;
	$arrTranslate = array();
	
	Core::getSingleton('Controller/Default')->actionIndex();
	if(ucfirst($controller) == 'Default') {
		$controller = 'Index';
	}

/*	Load controller {{*/
		$objCore->controller = $objCore->getSingleton('Controller/'.ucfirst($controller));
		if($objCore->getModel('Customer/Collection')->getCurrentCustomer()->checkPermission($controller, $method)) {
			if(method_exists($objCore->getSingleton('Controller/'.ucfirst($controller)), 'init')) {
				$objCore->getSingleton('Controller/'.ucfirst($controller))->init();
			}
			$objCore->getSingleton('Controller/'.ucfirst($controller))->$method();
		} elseif(!$objCore->getModel('Customer/Collection')->getCurrentCustomer()->get('id')) {
			$objCore->raiseError($objCore->getModel('Translate/Collection')->get('PAGE_ERROR_ACCESS_DENIED_NOT_REGISTERED')->get('value'));
		} else {
			$objCore->raiseError($objCore->getModel('Translate/Collection')->get('PAGE_ERROR_ACCESS_DENIED_REGISTERED')->get('value'));
		}
	
/*	Load controller }} */
	Core::getSingleton('Controller/Default')->_actionIndex();
}
$str = ob_get_contents();
ob_end_clean();
if(strlen(trim($str))>0) {
	$objCore->getSingleton('View')->setOutput('debug', $str);
}
$objCore->getSingleton('View')->displayOutput();
