<?php
/*
 * Created on 25 Кві 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Model_Payment_Module_PayPal_PayPal extends Model_Payment_Module {
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
 		$this->_core->assign('cartProducts', $this->_core->getModel('Cart')->getProducts());
 		$this->_core->assign('cartTotal', $this->_core->getModel('Cart')->subtotal());
// 		Core::getSingleton('Main')->addOutput(
// 				Core::getSingleton('Main')->fetch('payment', 'paypal/prepare.tpl')
// 			);
		$pVars = $args['objPayment']->get('variables');
//		die(print_r(,1));
		if ((int)$pVars['testmode']->get('value') < 1) {
			$api_url = 'https://api-3t.paypal.com/nvp';
			$loc_url = 'https://www.paypal.com/webscr';
		} else {
			$api_url = 'https://api-3t.sandbox.paypal.com/nvp';
			$loc_url = 'https://www.sandbox.paypal.com/webscr';
		}
// 		die('{'.'http://'.$this->_core->getSingleton('Config')->siteDomain . $this->_core->getSingleton('Config')->siteUrl . 'checkout/confirm'.'}');
 		$arrData = array(
 				'USER'=>$pVars['api_username']->get('value'),
 				'PWD'=>$pVars['api_password']->get('value'),
 				'RETURNURL'=>'http://'.str_replace('//','/',$this->_core->getSingleton('Config')->siteDomain . $this->_core->getSingleton('Config')->siteUrl . $this->_core->getSingleton('Config')->topFolder . 'checkout/confirm'),
 				'CANCELURL'=>'http://'.str_replace('//','/',$this->_core->getSingleton('Config')->siteDomain . $this->_core->getSingleton('Config')->siteUrl . $this->_core->getSingleton('Config')->topFolder),
 				'SIGNATURE'=>$pVars['api_signature']->get('value'),
 				'VERSION'=>'60.0',
 				'METHOD'=>'SetExpressCheckout',
				'AMT' => $this->_core->getModel('Cart')->subtotalsumm(),
				'CURRENCYCODE' => 'USD'//Core::getModel('Catalog/Currency/Collection')->getDefault()->get('code')
 			);
// 		die('<pre>'.print_r($arrData,1));
		$res = $this->_core->convertUrlStringToArray($this->_core->getModel('Connector')->sendPostData($api_url, $arrData));
 		if($res['ACK']=='Success') {
				$arrData['TOKEN'] = $res['TOKEN'];
				$arrData['METHOD'] = 'GetPalDetails';
				$arrData['PAYMENTACTION'] = 'Sale';
				$arrData['BUTTONSOURCE'] = 'WIDE_Software_1_0';
				header('Location: ' . $loc_url . '?cmd=_express-checkout&token=' . $res['TOKEN']);
		} else {
			$this->_core->raiseError($res['L_LONGMESSAGE0']);
		}
 	}
 	function confirm($args) {
 		$pVars = $args['objPayment']->get('variables');
// 		die($this->_core->getRequest('token') .' '. $this->_core->getRequest('PayerID'));
 		if($this->_core->getRequest('token') && $this->_core->getRequest('PayerID')) {
 			if ((int)$pVars['testmode']->get('value') < 1) {
				$api_url = 'https://api-3t.paypal.com/nvp';
				$loc_url = 'https://www.paypal.com/webscr';
			} else {
				$api_url = 'https://api-3t.sandbox.paypal.com/nvp';
				$loc_url = 'https://www.sandbox.paypal.com/webscr';
			}
 			$arrData = array(
 				'USER'=>$pVars['api_username']->get('value'),
 				'PWD'=>$pVars['api_password']->get('value'),
 				'SIGNATURE'=>$pVars['api_signature']->get('value'),
 				'VERSION'=>'60.0',
 				'METHOD'=>'GetExpressCheckoutDetails',
 				'TOKEN' => $this->_core->getRequest('token'),
	 			'PAYERID' => $this->_core->getRequest('PayerID')
 			);
// 			echo die('<pre>'.print_r($arrData, 1) . print_r($res,1).'</pre>');
 			$res = $this->_core->convertUrlStringToArray($this->_core->getModel('Connector')->sendPostData($api_url, $arrData));
 			
 			if($res['ACK']=='Success') {
 				$_SESSION['checkout']['buyer'] = $res;
 				$this->_core->getBlock('Payment/PayPal/Confirm')->setParam('arrBuyer', $_SESSION['checkout']['buyer'])->init();
//	 			$this->_core->assign('arrBuyer', $_SESSION['checkout']['buyer']);
//	 			$this->_core->addOutput(
//	 					Core::getSingleton('Main')->fetch('payment', 'paypal/confirm.tpl')
//	 				);
 			} else {
 				$this->_core->raiseError($res['L_LONGMESSAGE0']);
 			}
 		}
 	}
 	function process($args) {
// 		print_r($_SESSION['checkout']['buyer']);
//		$oStatuses = $this->_core->getModel('Order/Status/Collection')->newInstance()->getCollection('key');

		$pVars = $args['objPayment']->get('variables');
 		if($_SESSION['checkout']['buyer']['TOKEN'] && $_SESSION['checkout']['buyer']['PAYERID'] && $_POST['checkout']=='go') {
			if ((int)$pVars['testmode']->get('value') < 1) {
				$api_url = 'https://api-3t.paypal.com/nvp';
				$loc_url = 'https://www.paypal.com/webscr';
			} else {
				$api_url = 'https://api-3t.sandbox.paypal.com/nvp';
				$loc_url = 'https://www.sandbox.paypal.com/webscr';
			}
			$arrData = array(
 				'USER'=>$pVars['api_username']->get('value'),
 				'PWD'=>$pVars['api_password']->get('value'),
 				'SIGNATURE'=>$pVars['api_signature']->get('value'),
 				'VERSION'=>'60.0',
				'AMT' => $this->_core->getModel('Cart')->subtotalsumm(),
				'CURRENCYCODE' => 'USD'
 			);
 			$arrData['TOKEN'] = $_SESSION['checkout']['buyer']['TOKEN'];
	 		$arrData['PAYERID'] = $_SESSION['checkout']['buyer']['PAYERID'];
			$arrData['METHOD'] = 'DoExpressCheckoutPayment';
			$arrData['PAYMENTACTION'] = 'Sale';
//			die('<pre>'.print_r($this->_core->getModel('Currency/Collection')->fetch(),1));
			$res = $this->_core->convertUrlStringToArray($this->_core->getModel('Connector')->sendPostData($api_url, $arrData));
//			die($res['ACK']);
			$oStatuses = $this->_core->getModel('Order/Status/Collection')->newInstance()->getCollection('key');
			switch ( $res['ACK'] ) {
				case 'Success':
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
						));
					$order->push('cart', $this->_core->getModel('Cart')->getProducts());
					$order->save();
					$this->_core->getSingleton('Controller/Checkout')->finish($order);
					$this->_core->redirect('/checkout/success');
					break;
				case 'SuccessWithWarning':
					$this->_core->raiseWarning($res['L_LONGMESSAGE0']);
					$this->_core->getModel('Warning/Collection')->pushToSession();
					$this->_core->redirect('/checkout/success');
					break;
				default:
					$this->_core->raiseError($res['L_LONGMESSAGE0']);
					$this->_core->getModel('Error/Collection')->pushToSession();
					$this->_core->redirect('/checkout/failure');
					break;
			}
 		}
 		return false;
 	}
 }
?>