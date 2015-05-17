<?php
/**
 * File: index.php
 * Created on Nov 29, 2010
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@advancewebsoft.com>
 */

ini_set('display_errors', true);

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
setlocale(LC_ALL, 'uk_UA');
date_default_timezone_set('Europe/Kiev');
function fixPost($arr) {
  foreach($arr as $k=>$v) {
    if(is_array($v)) {
      $arr[$k] = fixPost($arr[$k]);
    } else {
      $arr[$k] = stripslashes($arr[$k]);
    }
  }
  return $arr;
}
if($_POST) {
  $_POST = fixPost($_POST);
}

$loc = pathinfo(__FILE__);
$loc = explode('/', $loc['dirname']);

unset($loc[sizeof($loc)-1]);
//unset($loc[0]);
$loc = str_replace('//', '/', '/'. implode('/', $loc) . '/');

chdir('../');

set_include_path($loc . PATH_SEPARATOR . $loc . 'classes/3rdparty/PEAR/'.PATH_SEPARATOR.$loc.'classes/3rdparty/');
require('classes/Core.php');
define('__PERMISSIONS__', true);

Core::getSingleton('Config');

$objCore = Core::getSingleton('Core');
if(isset($_SERVER['argv']) && !empty($_SERVER['argv']) && empty($_GET)) {
	foreach($_SERVER['argv'] as $k=>$v) {
		$v = explode('=', trim($v));
		if(strlen($v[0])>0 && strlen($v[1])>0) {
			$_GET[$v[0]] = $v[1];
		}
	}
}

$objCore->getSingleton('Controller');
$objCore->getResource('DB/Abstract');
$objCore->getResource('DB');
$objCore->getModel('Object');
$objCore->getModel('Collection/Abstract');
$objCore->getSingleton('Block');
$objCore->getBlock('Display');

include('includes/events.php');

$lifetime=3600*24;
$path = Core::getSingleton('Config')->adminUrl;

session_name('monako_backend');
session_set_cookie_params($lifetime, '/admin/', $objCore->getSingleton('Config')->cookieDomain);//,$objCore->getSingleton('Config')->adminUrl,'.'.$objCore->getSingleton('Config')->siteDomain);
session_start();
setcookie(session_name(),isset($_COOKIE[session_name()])?$_COOKIE[session_name()]:session_id(),time()+$lifetime);

$objCore->getModel('Language/Collection')->fetchLanguage();
$objCore->getModel('Translate/Collection')->addFilter('language', $objCore->getModel('Language/Collection')->getCurrentLanguage()->get($objCore->getModel('Language')->_id), 'eq')->getCollection('key');


define('ROOT_CATEGORY', Core::getSingleton('Config')->siteUrl);
define('ROOT_CATEGORY_NOSLASH', substr(ROOT_CATEGORY,0,-1));
define('ADM_TEMPLATE_DIR', Core::getSingleton('Config')->path . 'templates/default/admin/');
define('TEMPLATE_DIR', ROOT_CATEGORY . 'templates/default/admin/');
define('CONFIG_DIR', TEMPLATE_DIR . 'config/');
define('CURRENT_FOLDER', 'admin/');
if($objCore->getRequest('doctype')=='ajax') {
	$objCore->doctype = 'ajax';
}

$templateFile = 'index.tpl';
$url = $objCore->getUrl();
$admUrl = $objCore->getSingleton('Config')->adminUrl;

$objCore->getModel('Setting/Collection')->getCollection('key');

$arrUrl = explode('/', str_replace('//', '/', str_replace($admUrl, '', $url)));
if(!$objCore->notNull(trim($arrUrl[0]))) {
	array_shift($arrUrl);
}
$controller = $_GET['controller'] ? ucfirst($_GET['controller']) : array_shift($arrUrl);


if(!is_object($objCore->getSingleton('Controller/Admin/'.ucfirst($controller)))) {
	$controller = 'Index';
}
Core::getSingleton('Controller/Admin/Default')->actionIndex();
if(ucfirst($controller) == 'Default') {
	$controller = 'Index';
}
if(is_object(Core::getSingleton('Controller/Admin/'.ucfirst($controller)))) {
	$objCore->controllerUrl = $objCore->getSingleton('Config')->siteUrl . $controller;
	$objCore->controllerName = $controller;
	
	$action = $_GET['action']?ucfirst($_GET['action']):'Index';
	if(sizeof($arrUrl)>0) {
		$action = '';
		foreach($arrUrl as $val) {
			if(!isset($objCore->controllerTopAction)) {
				$objCore->controllerTopAction = ucfirst($val);
			}
			$action .= ucfirst($val);
		}
		if(!method_exists($objCore->getSingleton('Controller/Admin/'.ucfirst($controller)), 'action' . $action)) {
			$action = 'Index';
		}
	}
	$objCore->controllerAction = $action;
	$method = 'action' . $action;
	$arrTranslate = array();







/*	Load controller {{*/
if($objCore->getModel('User/Collection')->getCurrentUser()) {
  if(
	  $objCore->getModel('User/Collection')->getCurrentUser() &&
	  ( $objCore->getModel('User/Collection')->getCurrentUser()->checkPermission($controller, $method) || $method == 'actionLogout')) {
		  $objCore->controller = $objCore->getSingleton('Controller/Admin/'.ucfirst($controller));
		  if(method_exists($objCore->getSingleton('Controller/Admin/'.ucfirst($controller)), 'init')) {
			  $objCore->getSingleton('Controller/Admin/'.ucfirst($controller))->init();
		  }
		  $objCore->getSingleton('Controller/Admin/'.ucfirst($controller))->$method();
  } else {
	  $objCore->raiseError('No permissions to use "' . $method . '" in "' . $controller . '"');
  }
}
/*	Load controller }} */

}

$objCore->getSingleton('View')->displayOutput();
