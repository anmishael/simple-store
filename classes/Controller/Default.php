<?php
/**
 * File: Default.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

class Controller_Default extends Controller {
	function actionIndex() {
		$this->_core->getModel('Cart')->init();
		$this->_core->getBlock('Cart/Box')->init();
		$this->_core->getBlock('Language/Bar')->init();
		$this->_core->getBlock('Page/MenuHeader')->init();
		$this->_core->getBlock('Page/MenuTop')->init();
		$page = $this->_core->getModel('Page/Collection')->getCurrentPage();
// 		$this->_core->getBlock('Page/MenuAccountTop')->init();

		if(
			(
				!$this->_core->getModel('Customer/Collection')->getCurrentCustomer()
				||
				(!$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') && $this->_core->getUrl()!='/customer/login')
			) && (
				$page instanceof Model_Page && $page->category
				||
				!$page instanceof Model_Page
			)
		) {
			if(isset($_SESSION['customerid'])) unset($_SESSION['customerid']);
// 			$this->_core->getBlock('Page/MenuRegistration')->init()->getOutput();
//			$this->_core->getBlock('Customer/LoginBox')->init();
//		} elseif($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') && $this->_core->controllerName == 'customer') {
//			$this->_core->getBlock('Customer/Box')->init();
		}

		if( is_object($page) && $page->get('id')) {
			$this->_core->getModel('Page/History/Collection')->push($page);
		}
// 		$this->_core->getBlock('Page/NavSearch')->init();
		if(
			(is_object($page) && $page->get('id') && $page->get('category')==1)
		||
			!is_object($page)) {
			$this->_core->getBlock('Page/Category/Box')->init();
		}
		$this->_core->getBlock('Page/ContentLeft')->init();
		$this->_core->getBlock('Page/Content')->init();

		$this->_core->getBlock('Page/ContentRight')->init();
		$this->_core->getBlock('Page/SearchDescription')->init();
		$this->_core->getBlock('Page/Footer')->init();
// 		$this->_core->getBlock('Page/MenuBottom')->init();
	}
	function _actionIndex() {
		if( ($customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer()) instanceof Model_Customer) {
			$customer->updateCart();
		}
	}
}