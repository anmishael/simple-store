<?php
/**
 * File: Cart.php
 * Created on 7 лют. 2011
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@gmail.com>
 */

class Controller_Cart extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
	function actionIndex() {
		$this->_core->redirect($this->getActionUrl('cart-list'));
	}
	function actionList() {
		if($this->_core->doctype && is_object($this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype)))) {
			$this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype))->init();
		} else {
			$this->_core->getBlock('Cart/List')->init();
		}
	}
	function actionView() {
		if($this->_core->doctype && is_object($this->_core->getBlock('Cart/View/' . ucfirst($this->_core->doctype)))) {
			$this->_core->getBlock('Cart/View/' . ucfirst($this->_core->doctype))->init();
		} else {
			$this->_core->getBlock('Cart/View')->init();
		}
	}
	function actionAdd() {
		if( ($id = $this->_core->getRequest('id'))) {
			$qty = $this->_core->getRequest('qty');
			if(is_array($qty)) {
				foreach($qty as $k=>$q) {
					if(is_numeric($qty[$k])) {
						$this->_core->getModel('Cart')->add(
								$k,
								$qty[$k]
							);
					}
				}
			} else {
				if($this->_core->getRequest('id')>0 && is_numeric($this->_core->getRequest('id'))) {
					$this->_core->getModel('Cart')->add(
							$this->_core->getRequest('id'),
							is_numeric($qty)?$qty>0:1
						);
				}
			}
			
		}
		if($this->_core->doctype) {
			if(is_object($this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype))->init();
			}
		} else {
			if($this->_core->getRequest('redirect') && $this->_core->getRequest('redirect') !=$this->_core->getUrl()) {
				$this->_core->redirect($this->_core->getRequest('redirect'));
			} else {
				$this->_core->redirect($this->getActionUrl('cart-list'));
			}
		}
	}
	function actionRemove() {
		if($this->_core->getRequest('id')) {
			$this->_core->getModel('Cart')->remove($this->_core->getRequest('id'), $this->_core->getRequest('optionid'));
		}
		if($this->_core->doctype && is_object($this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype)))) {
			$this->_core->getBlock('Cart/List/' . ucfirst($this->_core->doctype))->init();
		} else {
			if($this->_core->getRequest('redirect') && $this->_core->getRequest('redirect') !=$this->_core->getUrl()) {
				$this->_core->redirect($this->_core->getRequest('redirect'));
			} else {
				$this->_core->redirect($this->getActionUrl('cart-list'));
			}
		}
	}
	function prepareUrls() {
		$this->pushUrl('cart-list', $this->_siteUrl . 'cart/list');
		$this->pushUrl('cart-view', $this->_siteUrl . 'cart/view');
		$this->pushUrl('cart-add', $this->_siteUrl . 'cart/add');
		$this->pushUrl('cart-remove', $this->_siteUrl . 'cart/remove');
	}
}
?>