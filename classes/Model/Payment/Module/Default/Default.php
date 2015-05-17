<?php
/**
 * File: Default.php
 * Created on 05.02.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

class Model_Payment_Module_Default_Default extends Model_Payment_Module {
	function install() {
		$arrConf = $this->getConfig();
		$data = array(
			'name'=>$arrConf['name'],
			'shortname'=>$arrConf['shortname'],
			'description'=>$arrConf['description']
		);
		$id = Core::getResource('Payment/Collection')->savePayment($data);
		foreach($arrConf['install']['data']['item'] as $k=>$v) {
			$data = array(
				'payment'=>$id,
				'name'=>$v['key'],
				'value'=>$v['value']
			);
			Core::getResource('Payment/Collection')->savePaymentValues($data);
		}
	}
	function prepare($args) {
		$this->_core->getBlock('Payment/Default/Prepare')->setParam('cartProducts', $this->_core->getModel('Cart')->getProducts())
			->setParam('cartTotal', $this->_core->getModel('Cart')->subtotalsumm())
			->setParam('arrCustomer', $this->_core->getModel('Customer/Collection')->getCurrentCustomer()->toArray())
			->setParam('objShipping', $this->_core->getModel('Shipping/Collection')->getCollection())
			->setParam('shipping_method', $this->_core->getRequest('shipping_method'))
			->setParam('arrBuyer', $_SESSION['checkout']['buyer'])->init();
	}
	function confirm() {
		$_SESSION['checkout']['buyer'] = $res;
		$this->_core->assign('arrBuyer', $_SESSION['checkout']['buyer']);
		if(
			strlen(trim($this->_core->getRequestPost('shipname_first')))>0 &&
//			strlen(trim($this->_core->getRequestPost('shipname_last')))>0 &&
//			strlen(trim($this->_core->getRequestPost('shipcity')))>0 &&
//			strlen(trim($this->_core->getRequestPost('shipstate')))>0 &&
//			strlen(trim($this->_core->getRequestPost('shipaddress1')))>0 &&
			strlen(trim($this->_core->getRequestPost('shipphone')))>0
		) {
			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipname_first', $this->_core->getRequestPost('shipname_first'));
//			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipname_last', $this->_core->getRequestPost('shipname_last'));
//			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipcity', $this->_core->getRequestPost('shipcity'));
//			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipstate', $this->_core->getRequestPost('shipstate'));
//			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipaddress1', $this->_core->getRequestPost('shipaddress1'));
			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->push('shipphone', $this->_core->getRequestPost('shipphone'));
			$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->save();
			$this->_core->getBlock('Payment/Default/Confirm')
				->setParam('arrCustomer', $this->_core->getModel('Customer/Collection')->getCurrentCustomer()->toArray())
				->setParam('arrCurrency', $this->_core->getModel('Currency/Collection')->fetch()->toArray())
				->setParam('cartTotal', $this->_core->getModel('Cart')->subtotalsumm())
				->init();
		} else {
			$_SESSION['lastpost'] = $this->_core->getRequestPost();
			$this->_core->redirect('/checkout/prepare');
		}
	}
	function process() {
		$this->_core->getModel('Order');
		$oStatuses = $this->_core->getModel('Order/Status/Collection')->newInstance()->getCollection('key');
		$shipping = $this->_core->getModel('Shipping/Collection')->newInstance()
			->addGroupFilter('search', 'name', $_SESSION['shipping_method'], 'like')
			->addGroupFilter('search', 'label', $_SESSION['shipping_method'], 'like')
			->getOne();
		if(!$shipping instanceof Model_Shipping) {
			$this->_core->raiseError('Missing shipping method "'.$this->_item->get('shipping_method').'"');
			return false;
		}

		 $order = $this->_core->getModel('Order')->newInstance( array(
							'cid'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id'),
			 				'cardcode'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('cardcode'),
							'name_first'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_first'),
							'name_last'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_last'),
							'phone'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('phone'),
							'subtotal'=>$this->_core->getModel('Cart')->subtotal(),
							'subtotalsumm'=>$this->_core->getModel('Cart')->subtotalsumm(),
							'email'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('email'),
							'total'=>$this->_core->getModel('Cart')->subtotal(),
							'totalsumm'=>$this->_core->getModel('Cart')->subtotalsumm(),
							'status'=>$oStatuses['pending']->get('id'),
							'statusid'=>$oStatuses['pending']->get('id'),
							'billname_first'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_first'),
							'billname_last'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_last'),
							'shipname_first'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipname_first'),
							'shipname_last'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipname_last'),
							'shipaddress1'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipaddress1'),
							'shipcity'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipcity'),
							'shipstate'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipstate'),
							'shipphone'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('shipphone'),
							'currency'=>$this->_core->getModel('Currency/Collection')->fetch()->get('code'),
							'comment'=>$_SESSION['lastpost']['comment'],
							'shipping_method'=>$_SESSION['shipping_method'],
			 				'shipping'=>$shipping->get($shipping->_id)
//							'created'=>date('Y-m-d H:i:s')
						));
		 //*/
		/*
		$this->_core->getModel('Order');
		$order = new Model_Order( array(
			'cid'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id'),
			'name_first'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_first'),
			'name_last'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('name_last'),
			'phone'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('phone'),
			'email'=>$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('email'),
			'total'=>$this->_core->getModel('Cart')->subtotalsumm(),
			'subtotal'=>$this->_core->getModel('Cart')->subtotal(),
			'status'=>$oStatuses['paid']->get('id'),
			'changed'=>date('Y-m-d h:i:s'),
			'currency'=>$this->_core->getModel('Currency/Collection')->fetch()->get('code'),
			'comment'=>$_SESSION['lastpost']['comment']
		));//*/
//		$this->_core->setDebug(99);
		$order->push('cart', $this->_core->getModel('Cart')->getProducts());
		$order->save();
//		die('<pre>'.print_r($order,1));
		$this->_core->getSingleton('Controller/Checkout')->finish($order);
//		$this->_core->setDebug(0);
//		die();
		$this->_core->redirect('/checkout/success');
//		$order->push('cart', $this->_core->getModel('Cart')->getProducts());
//		$order->save();
//		$this->_core->getSingleton('Controller/Checkout')->finish($order);
//		$this->_core->setRedirect('/checkout/success');
	}
}