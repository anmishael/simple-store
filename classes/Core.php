<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Core {
	public static $arrObjects = array();
	public static $arrUrl;
	public static $slash;
	public static $arrGetUrls;
	public static $actionUrls = array();
	public static $controllerName = null;
	public static $_events = array();
	public static $_post;
	function __construct() {
		$this->controllerName = '';
		$this->_doctypes = array('json', 'xml', 'pdf');
		if($this->getRequest('doctype') && in_array($this->getRequest('doctype'), $this->_doctypes)) {
			$this->doctype = $this->getRequest('doctype');
		}
		$this->_post = $this->fixSlashes($_POST);
	}
	function fixSlashes($arr) {
		foreach($arr as $k=>$v) {
			if(is_array($v)) {
				$arr[$k] = self::fixSlashes($arr[$k]);
			} else {
				$arr[$k] = stripslashes($arr[$k]);
			}
		}
		return $arr;
	}

	/**
	 * @param $objectName
	 * @param bool $args
	 * @return null|Model_Object|Model_Collection_Abstract|Model_Collection|Block_Display|Block|Controller
	 */
	function getSingleton($objectName, $args = false) {
		if(is_object($objectName)) {
			if(!( self::_getObject(get_class($objectName)) ) ) {
				self::_addObject(get_class($objectName), $objectName);
			}
			return  self::_getObject(get_class($objectName));
		} else {
			$arrObj = explode('/', $objectName);
			if(!(self::_getObject($objectName))) {
				$filePath = self::_getFile($objectName);
				if(file_exists($filePath)) {
					require_once($filePath);
					$className = implode('_', $arrObj);
					if(class_exists($className)) {
						if($args)
							self::_addObject($objectName, new $className($args));
						else
							self::_addObject($objectName, new $className());
					} else {
//						die('Class "' . $className .'" does not exists.');
					}
				} else {
//					die('File do not exists: ' . $filePath);
				}
			}
		}
		return self::_getObject($objectName);
	}

	/**
	 * @param $obj
	 * @param null $args
	 * @return mixed|Model_Object|Model_Collection_Abstract|Model_Collection|Block_Display|Block|Controller
	 */
	function newInstance($obj, $args = null) {
		$cls = get_class($obj);
		return new $cls($args);
	}
	function assign($key, $value) {
		if(!isset($this->$key)) {
			$this->$key = $value;
		} else {
			if(is_array($this->$key) && is_array($value)) {
				$this->$key = array_merge($this->$key, $value);
			}
		}
		return $this;
	}
	function getActionUrl($key) {
		return $this->actionUrls[$key];
	}
	function redirect($url) {
		if($this->getModel('Error/Collection')->size()>0) {
			$this->getModel('Error/Collection')->pushToSession();
		}
		if($this->getModel('Warning/Collection')->size()>0) {
			$this->getModel('Warning/Collection')->pushToSession();
		}
		header("Location: " . $url);
	}
	function array_to_input($array, $prefix = '', $res = array(), $force_keys = false) {
		if($force_keys || (bool)count(array_filter(array_keys($array), 'is_string')) ) {
			foreach($array as $key => $value) {
				if( empty($prefix) ) {
					$name = $key;
				} else {
					$name = $prefix.'['.$key.']';
				}
				if( is_array($value) ) {
					$res = array_merge($res, $this->array_to_input($value, $name, $res, $force_keys));
				} else {
					$res[] = array('name'=>$name, 'value'=>$value);
				}
			}
		} else {
			foreach($array as $k=>$item) {
				if( is_array($item) ) {
					$res = array_merge($res, $this->array_to_input($item, $prefix.'[]', $res, $force_keys));
				} else {
					$res[] = array('name'=>$prefix . '[]', 'value'=>$item);
				}
			}
		}
		return $res;
	}

	/**
	 * @param String $objectName
	 * @param bool|mixed $args
	 * @return Model_Object|Model_Collection_Abstract|Model_Collection
	 */
	function getModel($objectName, $args = false) {
		return self::getSingleton('Model/'.$objectName, $args);
	}

	/**
	 * @param $objectName
	 * @param bool $args
	 * @return Resource_DB|Resource_DB_Abstract|Resource_DB_MySQL|null
	 */
	function getResource($objectName, $args = false) {
		return self::getSingleton('Resource/'.$objectName, $args);
	}
	function getBlock($objectName, $args = false) {
		return self::getSingleton('Block/'.$objectName, $args);
	}
	function _addObject($name, $obj) {
		self::$arrObjects[strtolower($name)] = &$obj;
	}
	function _getObject($name) {
		if(isset(self::$arrObjects[strtolower($name)])) {
			return self::$arrObjects[strtolower($name)];
		}
		return null;
	}
	function _getFile($objectName) {
		global $objCfg;
		$file = false;
		$path = 'classes/';
		if(is_object($objCfg) && strlen($objCfg->path)>0) $path = $objCfg->path . '/' . $path;
		else {
			$path = pathinfo(__FILE__);
			$path = $path['dirname'] . '/';
		}
		if(file_exists($path)) {
			$file = $path . $objectName . '.php';
		}
		return $file;
	}
	function getFolder($file, $up = 0) {
		/*
    	if(!self::notNull(self::$slash)) {
    		self::getSystemSlash();
    	}
    	$path = explode(self::$slash, $file);
    	unset($path[sizeof($path)-1]);
    	if(strlen($path[0])>0 && strstr(':', $path[0])) unset($path[0]);
    	for($x=0;$x<$up;$x++) {
    		unset($path[sizeof($path)-1]);
    	}
    	$path = implode(self::$slash, $path) . self::$slash;
    	*/
    	
		$file = self::fixFolderSlash($file);
		if(!is_dir($file)) {
// 			echo $file.'<br>';
			$file = dirname($file) . '/';
// 			echo $file .'<br>';
		};
		for($k=0;$k<$up;$k++) {
			$file = dirname($file).'/';
// 			echo $file.'<br>';
		}
// 		die($file);
		return $file;
	}
	function mkFolders($path) {
		if(!file_exists($path)) {
			self::mkFolders(self::getFolder($path,1));
			if(!mkdir($path,0777)) {
				self::raiseError('Could not create "'.$path.'"!');
			}
		}
	}
	function listFolder($folder, $arrFiles = array(), $deep = 0) {
//    	$folder = self::fixFolderSlash($folder);
		$d = dir($folder);
		$slash = self::getSystemSlash();
		if(is_object($d)) {
			if($deep == 0 || !$deep) {
				while( false !== ($e = $d->read()) ) {
					if($e != '..' && $e != '.') {
						if(is_file($folder . $slash . $e)) {
							$arrFiles[] = $folder . $slash . $e;
						}
					}
				}
			} elseif($deep<0) {
				while( ($e = $d->read()) ) {
					if($e != '..' && $e != '.') {
						if(is_file($folder . $slash . $e)) {
							$arrFiles[] = $folder . $slash . $e;
						} elseif(is_dir($folder . $slash . $e)) {
							$arrFiles = array_merge($arrFiles, $this->listFolder($folder . $slash . $e, array(), $deep));
						}
					}
				}
			} elseif($deep>0) {
				while( ($e = $d->read()) ) {
					if($e != '..' && $e != '.') {
						if(is_file($folder . $slash . $e)) {
							$arrFiles[] = $folder . $slash . $e;
						} elseif(is_dir($folder . $slash . $e)) {
							$arrFiles = array_merge($arrFiles, $this->listFolder($folder . $slash . $e, array(), ($deep-1)));
						}
					}
				}
			}
			$d->close();
		}
		return $arrFiles;
	}
	function fixFolderSlash($path) {
		if(isset($_SERVER['WINDIR'])) {// && !self::getSingleton('Config')->wrapSlash) {
			$path = str_replace('\\', '/', $path);
			$path = explode('/', $path);
			if(strlen($path[0])>0 && stristr($path[0],':')) {
				array_shift($path);
			}
			$path = str_replace('//','/','/'.implode('/', $path));
		}
		return $path;
	}
	function raiseError($text, $toSession = false, $code = false) {
		if($this->getModel('Config')->error_die) {
			die('<html><head><title>Error</title><link rel="stylesheet" href="/templates/default/css/error.css" /></head><body><div class="error">' . $text.'</div></body></html>');
		} else {
			$this->getModel('Error/Collection')->put($this->getModel('Error')->newInstance(array('title'=>'Error', 'content'=>$text)));
			if($toSession) {
				$this->getModel('Error/Collection')->pushToSession();
			}
			if($code) {
				header("HTTP/1.0 $code");
			}
		}
		return $this;
	}
	function raiseWarning($text, $toSession = false) {
		if($this->getModel('Config')->error_die) {
			die('<html><head><title>Warning</title><link rel="stylesheet" href="/templates/default/css/warning.css" /></head><body><div class="warning">' . $text.'</div></body></html>');
		} else {
			$this->getModel('Warning/Collection')->put($this->getModel('Warning')->newInstance(array('title'=>'Warning', 'content'=>$text)));
			if($toSession) {
				$this->getModel('Warning/Collection')->pushToSession();
			}
		}
		return $this;
	}
	function setReturnStatus($status) {
		$this->_return_status = $status;
		return $this;
	}
	function setDebug($level) {
		self::getResource('DB')->getConnection()->debug = $level;
		$this->debug = $level;
		return $this;
	}
	function getDebug() {
		return $this->debug;
	}
	function notNull($variable=null) {
		$type = gettype($variable);
		$res = true;
		switch ($type) {
			case 'NULL':
				$res = false;
				break;
			case 'string':
				if(strlen(trim($variable))<1) $res = false;
				break;
			case 'array':
				if(sizeof($variable)<=0) {
					$res = false;
				} else {
					foreach($variable as $k=>$v) {
						if(is_array($v)) {
							$res = $this->notNull($v);
							//print_r($variable);
							//echo $res;
							//exit;
						} else {
							$res = $this->notNull(trim($v));
						}
						if($res) return true;
					}
				}
				break;
			case 'integer':
			case 'double':
			case 'float':
				if($variable == 0) $res = false;
				break;
				break;
				break;
			case 'boolean': $res = $variable;
			default:
				if($variable == null || strlen(trim($variable) )<=0) $res = false;
				break;
		}
		return $res;
	}
	function getSystemSlash() {
		if(!self::notNull(self::$slash)) {
			$slash = '/';
			if(isset($_SERVER['WINDIR']) && self::notNull($_SERVER['WINDIR'])) {
				$slash = '\\';
			}
			self::$slash = $slash;
		}
		return self::$slash;
	}
	function getUrl() {
		if(!self::$arrUrl || empty(self::$arrUrl)) {
			self::_getUrl();
		}
		return self::$arrUrl[0];
	}
	function _getUrl() {
		self::$arrUrl = explode('?', urldecode($_SERVER["REQUEST_URI"]));
		return $this;
	}
	function urlify($name, $key, $val) {
		return '[' . urlencode($key) . ']=' . urlencode($val);
	}
	function getAllGetParams($excluds = array()) {
		$res = array();
		if(!isset(self::$arrGetUrls[implode($excluds)])) {
			$get = self::getRequestGet();
			foreach($get as $k=>$v) {
				if(!in_array($k, $excluds)) {
					if(!is_array($v)) {
						$res[] = $k . '=' . $v;
					} else {
						$res[] = http_build_query(array($k=>$v));
					}
				}
			}
			$res = implode('&', $res);
			self::$arrGetUrls[implode($excluds)] = $res;
		}
		$res = self::$arrGetUrls[implode($excluds)];
		return $res;
	}
	function arrToUrl($arr, $excluds = array()) {
		$res = array();
		foreach($arr as $k=>$v) {
			if(!in_array($k, $excluds)) {
				if(!is_array($v)) {
					$res[] = $k . '=' . $v;
				} else {
					$res[] = http_build_query(array($k=>$v));
				}
			}
			$res = implode('&', $res);
		}
		return $res;
	}
	function getAllGetArray($exclude) {
		$get = $this->getRequestGet();
		if(is_array($exclude)) {
			foreach($exclude as $name) {
				unset($get[$name]);
			}
		}
		return $get;
	}
	function getGetSize() {
		return sizeof($_GET);
	}
	function getPostSize() {
		return sizeof($this->_post);
	}
	function getRequest($name = false) {
		if(isset($this->request[$name])) return $this->request[$name];
		if(strlen($name)>0) {
			if(isset($this->_post[$name])) $this->request[$name] = $this->_post[$name];
			elseif(isset($_GET[$name])) $this->request[$name] = $_GET[$name];
			elseif(isset($_SESSION[$name])) $this->request[$name] = $_SESSION[$name];
		}
		return isset($this->request[$name])?$this->request[$name]:null;
	}
	function setRequest($key, $val) {
		$this->request[$key] = $val;
		return $this;
	}
	function getRequestPost($name=false) {
		$res = $this->_post;
		if($name) {
			$res = isset($this->_post[$name]) ? $this->_post[$name] : false;
		}
		return $res;
	}
	function getRequestGet($name=false, $striptags = true) {
		$res = $_GET;
		if($name) {
			$res = isset($_GET[$name]) ? strip_tags($_GET[$name]) : false;
		}
		return $res;
	}
	function getRequestSess($name=false) {
		$res = $_SESSION;
		if($name) {
			$res = isset($_SESSION[$name]) ? $_SESSION[$name] : false;
		}
		return $res;
	}
	function generateRandom($size = 8) {
		$str = 'VWXYZ123abcdefgHIJKLMNOPQ456hijrstuvwxyzABCDEFG789RSTUklmnopq';
		$res = '';
		$_size = strlen($str)-1;
		for($x=0;$x<$size;$x++) {
			$res .= substr($str, rand(0, $_size), 1);
		}
		return $res;
	}
    function addEvent($event, $data) {
		if(!is_array($this->_events[$event])) $this->_events[$event] = array();
		$this->_events[$event][] = $data;
		return $this;
	}
    function dispatchEvent($event, $obj = null) {
		if(is_array($this->_events[$event])) {
			foreach($this->_events[$event] as $key=>$val) {
				if($val['controller'] && $val['method']) {
					self::getSingleton('Controller/'.$val['controller'])->$val['method']($obj);
				} elseif($val['model'] && $val['method']) {
					self::getModel($val['controller'])->$val['method']($obj);
				}
			}
		}
		return $this;
	}
    function emailIsValid($email) {
		return preg_match("/^(?=.{5,254})(?:(?:\"[^\"]{1,62}\")|(?:(?!\.)(?!.*\.[.@])[a-z0-9!#$%&'*+\/=?^_`{|}~^.-]{1,64}))@(?:(?:\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9]?[0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9]?[0-9])\])|(?:(?!-)(?!.*-\$)(?!.*-\.)(?!.*\.-)(?!.*[^n]--)(?!.*[^x]n--)(?!n--)(?!.*[^.]xn--)(?:[a-z0-9-]{1,63}\.){1,127}(?:[a-z0-9-]{1,63})))$/i", $email);
	}
 }