<?php
/**
 * File: Cart.php
 * Created on 7 лют. 2011
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

class Model_Cart extends Model_Object {
	var $_customer;
	var $_customer_type;
	function __construct($data = array()) {
		parent::__construct($data);
		$this->_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer();
	}
	function init() {
		if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
			$_SESSION['cart'] = $this->_core->getModel('Cart/Collection')->getCollection();
		}

		if(sizeof($_SESSION['cart'])>0) {
			$arrIDs = array();
			$arrIDsSuff = array();
			$arrQTY = array();
			foreach($_SESSION['cart'] as $k=>$v) {
				/*
				if(strlen(trim($v['id']))>0) {
					$suff = '';
					if(sizeof($v['options'])>0) {
						$suff = array();
						foreach($v['options'] as $x=>$y) {
							$suff[] = $x . '_' . $y;
						}
						$suff = implode('.', $suff);
						$suff = ':' . $suff;
					}
					$arrIDs[]=$v['id'];
					if(!$arrIDsSuff[$v['id']]) {
						$arrIDsSuff[$v['id']] = array();
					}
					$arrIDsSuff[$v['id']][] = $suff;
//					$arrQTY[$v['id'].$suff] = $v['qty'];
					$arrQTY[$v['id']] = $v['qty'];
				}
				$arrIDsSuff[$v['id']] = array_unique($arrIDsSuff[$v['id']]);
				//*/
				$arrIDs[]=$v['id'];
				$arrQTY[$v['id']] = $v['qty'];
			}

			if(sizeof($arrIDs)>0) {
				$objCollection = $this->_core->getModel('Product/Collection')->newInstance()
							->clear()
							->addFilter('id',$arrIDs,'in')
							->addFilter('status',0,'neq');
				if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
					$objCollection->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
				}
				$objCollection = $objCollection->getCollection('id');
				foreach($objCollection as $k=>$v) {
					$objCollection[$k]->push('qty', $arrQTY[$v->get('id')]);
				}
				$v = null;
				$this->_core->getModel('Cart/Collection')
					->clear()
					->setCollection(
						$objCollection
					);
				$this->save();
			}
//			die(print_r($_SESSION['cart']));
		}
//		die(print_r($_SESSION['cart']));
	}
	function add($pID,$qty=1,$arrOptions = array()) {
		if($qty==0) {
			$this->remove($pID, $arrOptions);
			return true;
		}
		if((int)$qty<=0) $qty=1;
		$objProdCollection = $this->_core->getModel('Product/Collection')->newInstance();
		$suff = '';
		if(sizeof($arrOptions)>0) {
			$suff = array();
			foreach($arrOptions as $x=>$y) {
				$suff[] = $x . '_' . $y;
			}
			$suff = implode('.', $suff);
			$suff = ':' . $suff;
		}
		if(is_object($objProduct = $this->_core->getModel('Cart/Collection')->get($pID . $suff)) && $objProduct instanceof Model_Product && $objProduct->get('status')!=0) {
			if($qty>$objProduct->get('quantity')) {
				$qty = $objProduct->get('quantity');
			}
			$objProduct->push('qty', $qty);
			$objProduct->push('subtotal', ($qty*$objProduct->getPrice()));
			$objProduct->push('options', $arrOptions);
//			$objProduct->applyFilterPrices()->summPrices();
			$objProduct->push('subtotalsumm', ($qty*$objProduct->get('summ')));
			if($objProduct->get('qty')>0 && $objProduct->get('price')>0) {
				$this->_core->getModel('Cart/Collection')
					->push(
						$pID . $suff,
						$objProduct
					);
			}
		} else {
			$objProduct = $objProdCollection
					->addFilter('id',$pID,'eq')
					->addFilter('status', 1, 'eq');
			if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
				$objProduct->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
			}
			$objProduct = $objProduct->getOne();
			if($objProduct instanceof Model_Product) {
				if($qty>$objProduct->get('quantity')) {
					$qty = $objProduct->get('quantity');
				}
				$objProduct->push('qty', $qty);
				$objProduct->push('subtotal', ($objProduct->get('qty')*$objProduct->getPrice()));
				$objProduct->push('options', $arrOptions);
				$objProduct->push('subtotalsumm', ($objProduct->get('qty')*$objProduct->getPrice()));
				if($objProduct->get('qty')>0 && $objProduct->get('price')>0) {
					$this->_core->getModel('Cart/Collection')
						->push(
							$pID . $suff,
							$objProduct

						);
				}
			}
		}

//		echo '<pre>'.print_r($objProduct,1).'</pre>';
		$this->save();
//		die('<pre>'.print_r($_SESSION['cart'],1).'</pre>');
	}
	function remove($pID, $arrOptions = array()) {
		$suff = '';
		if(sizeof($arrOptions)>0) {
			$suff = array();
			foreach($arrOptions as $x=>$y) {
				$suff[] = $x . '_' . $y;
			}
			$suff = implode('.', $suff);
			$suff = ':' . $suff;
		}
		if($pID) {
			$this->_core->getModel('Cart/Collection')->pop($pID . $suff);
			$this->save();
		}
	}
	function save() {
		$_SESSION['cart'] = $this->_core->getModel('Cart/Collection')->getCollection();
		foreach($_SESSION['cart'] as $k=>$v) {
			if(is_object($v)) {
				$_SESSION['cart'][$k] = $v->toArray();
			}
		}
//		die('<pre>'.print_r($_SESSION['cart'],1));
		return $this;
	}
	function size() {
		return $this->_core->getModel('Cart/Collection')->size();
	}
	function subtotal() {
		$objProducts = $this->_core->getModel('Cart/Collection')->getCollection();
		$subtotal = 0;
		foreach($objProducts as $k=>$product) {
			$subtotal += $product->get('price')*($product->get('qty')>0?$product->get('qty'):1);
		}
		$objProducts = null;
		unset($objProducts);
		return $subtotal;
	}
	function subtotalsumm() {
		$objProducts = $this->_core->getModel('Cart/Collection')->getCollection();
		$subtotal = 0;
		foreach($objProducts as $k=>$product) {
			$subtotal += $product->getPrice()*($product->get('qty')?$product->get('qty'):1);
		}
		$objProducts = null;
		unset($objProducts);
		return $subtotal;
	}
	function getProducts() {
		return $this->_core->getModel('Cart/Collection')->getCollection();
	}
	function destroy() {
		$this->_core->getModel('Cart/Collection')->clear();
		$_SESSION['cart'] = null;
		unset($_SESSION['cart']);
	}
}
