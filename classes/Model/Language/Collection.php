<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */

class Model_Language_Collection extends Model_Collection_Abstract {
	var $_table = 'languages';
	var $_id = 'id';
	var $_model = 'Language';
	var $_lang;
	var $_languages;
	function getAllLanguages() {
		if(!$this->_languages) {
			$this->_languages = $this->newInstance()->getCollection();
		}
		return $this->_languages;
	}
	function fetchLanguage() {
		unset($_SESSION['lang']);
		if(!$this->_core->getRequestSess('lang') || $this->_core->getRequest('lng')) {
			if($this->_core->getRequest('lng') && ($lng = $this->newInstance()->addFilter('status', 1, 'eq')->addFilter('code', $this->_core->getRequest('lng'), 'eq')->getOne()) instanceof Model_Language ) {
				$this->_lang = $lng;
				$_SESSION['lang'] = $lng->get('code');
			} elseif($_SERVER['HTTP_ACCEPT_LANGUAGE']) {
				$arrlng = explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
				$arrlng = explode(',', $arrlng[0]);
				foreach($arrlng as $code) {
					$lng = $this->newInstance()->addFilter('status', 1, 'eq')->addFilter('code', $code, 'eq')->getOne();
					if($lng instanceof Model_Language) {
						$this->_lang = $lng;
						$_SESSION['lang'] = $lng->get('code');
						break;
					}
				}
			}
			if(!$this->_lang instanceof Model_Language) {
				$this->_lang = $this->newInstance()->addFilter('status', 1, 'eq')->getOne();
			}
		} else {
			$lng = $this->newInstance()->addFilter('status', 1, 'eq')->addFilter('code', $this->_core->getRequestSess('lang'), 'eq')->getOne();
			if($lng instanceof Model_Language ) {
				$this->_lang = $lng;
			} else {
				$lng = $this->newInstance()->addFilter('status', 1, 'eq')->getOne();
				if($lng instanceof Model_Language ) {
					$this->_lang = $lng;
				} else {
					die('Language fetching error!');
				}
			}
		}
		return $this;
	}
	function getCurrentLanguage() {
		return $this->_lang;
	}
}