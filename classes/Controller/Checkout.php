<?php
/**
 * File: Checkout.php
 * Created on 7 лют. 2011
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <anmishael@gmail.com>
 */

class Controller_Checkout extends Controller {
 	function __construct() {
 		parent::__construct();
 		$this->prepareUrls();
 	}
	function actionIndex() {
//		die();
		if($this->_core->getModel('Cart/Collection')->size()<=0) $this->_core->redirect($this->_core->getSingleton('Controller/Cart')->getActionUrl('cart-list'));
//		if(!Core::getModel('Customer/Collection')->getCurrent()->get('id')) {
//			Core::getSingleton('Main')->setRedirect('/customer/login');
//		}
		if((int)$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') == 0) {
			$_SESSION['redirect'] = $this->getActionUrl('checkout-index');
			$this->_core->redirect($this->_core->getSingleton('Controller/Customer')->getActionUrl('customer-login'));
			return;
		}
		unset($_SESSION['checkout']['method']);
		if($this->_core->getRequest('method')) {
			if(!$_SESSION['checkout']) $_SESSION['checkout'] = array();
			$_SESSION['checkout']['method'] = $this->_core->getModel('Payment/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('method'), 'eq')
				->getOne();
		}
		if($_SESSION['checkout']) {
			if($_SESSION['checkout']['error']) {
				$this->_core->raiseError($_SESSION['checkout']['error']);
				unset($_SESSION['checkout']['error']);
			}
//			Core::getSingleton('Main')->assign('arrData', $_SESSION['checkout']['data']);
		}
		$arrMethods = $this->_core->getModel('Payment/Collection')->newInstance()->addFilter('status', 1, 'eq')->getCollection();
//		die('<pre>'.print_r($arrMethods,1).'</pre>');
		if(sizeof($arrMethods) == 1 && !$this->_core->getRequest('method')) {
			$arrMethod = array_pop($arrMethods);
			$_SESSION['checkout']['method'] = $arrMethod->fetchVariables()->toArray();
			$_SESSION['checkout']['method']['variables'] = $arrMethod->get('variables');
			foreach($_SESSION['checkout']['method']['variables'] as $k=>$v) {
				$_SESSION['checkout']['method']['variables'][$k] = $v->toArray();
			}
//			die('<pre>'.print_r($_SESSION['checkout']['method'],1).'</pre>');
			$this->_core->redirect($this->getActionUrl('checkout-index') . '?method=' . $arrMethod->get($arrMethod->_id));
			return $this;
		}
		if($_SESSION['checkout']['method']) {//} && Core::getSingleton('Main')->getRequest('method')>0) {
			if(is_object($_SESSION['checkout']['method'])) {
//				die('<pre>'.print_r($_SESSION['checkout']['method'],1));
				$_SESSION['checkout']['method'] = $_SESSION['checkout']['method']->toArray();
				foreach($_SESSION['checkout']['method']['variables'] as $k=>$v) {
					$_SESSION['checkout']['method']['variables'][$k] = $v->toArray();
				}
			}
//			die('<pre>'.print_r($_SESSION['checkout']['method'],1));
			$this->_core->redirect($this->getActionUrl('checkout-prepare'));
		}
		$this->_core->getBlock('Checkout/Method')->init();
	}
	function actionPrepare() {
		if($this->_core->getModel('Cart/Collection')->size()<=0) $this->_core->redirect($this->_core->getSingleton('Controller/Cart')->getActionUrl('cart-list'));
		if((int)$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') == 0) {
			$_SESSION['redirect'] = $this->getActionUrl('checkout-prepare');
			$this->_core->redirect($this->_core->getSingleton('Controller/Customer')->getActionUrl('customer-login'));
			return;
		}
		
		$_SESSION['lastpost'] = array_merge($_SESSION['lastpost'], $this->_core->getRequestPost());
		if(!$_SESSION['checkout']['method']) $this->_core->redirect($this->getActionUrl('checkout-index'));
//		if(!is_object($_SESSION['checkout']['method']) || !$_SESSION['checkout']['method'] instanceof Model_Payment) {
//			die('<pre>'.print_r($_SESSION['checkout']['method']['_data'],1));
//			$_SESSION['checkout']['method'] = $this->_core->getModel('Payment')->newInstance($_SESSION['checkout']['method']->_data);
//		}
//		die(print_r($_SESSION['checkout']['method'],1));
		
		$objPayment = $this->_core->getModel('Payment/Collection')
			->addFilter('id', $_SESSION['checkout']['method']['id'], 'eq')
			->getOne();
		
//		die('<pre>'.print_r($objPayment,1));
		if(is_object($objPayment)) {
			$objPayment->fetchVariables();
			$objPaymentModule = $objPayment->getModuleObject();
//			print_r($objPaymentModule);
			$this->dispatchAction($objPayment, $objPaymentModule);
		}
	}
	function actionConfirm() {
		if($this->_core->getModel('Cart/Collection')->size()<=0) $this->_core->redirect($this->_core->getSingleton('Controller/Cart')->getActionUrl('cart-list'));
		if((int)$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') == 0) {
			$_SESSION['redirect'] = $this->getActionUrl('checkout-confirm');
			$this->_core->redirect($this->_core->getSingleton('Controller/Customer')->getActionUrl('customer-login'));
			return;
		}
//		die(print_r($_SESSION['checkout']['method']));
//		if(!$this->_core->getRequest('shipping_method')) {
//			$this->_core->redirect($this->getActionUrl('checkout-prepare'));
//		}
		if(!is_array($_SESSION['lastpost'])) $_SESSION['lastpost'] = array();
		$_SESSION['lastpost'] = array_merge($_SESSION['lastpost'], $this->_core->getRequestPost());
		foreach($_SESSION['lastpost'] as $k=>$v) {
			if(!is_array($v)) {
				$_SESSION['lastpost'][$k] = htmlspecialchars($v);
			}
		}
		if(!$_SESSION['checkout']['method']) $this->_core->redirect($this->getActionUrl('checkout-index'));
		$_SESSION['shipping_method'] = $this->_core->getRequest('shipping_method');
		$objPayment = $this->_core->getModel('Payment/Collection')
			->addFilter('id', $_SESSION['checkout']['method']['id'], 'eq')
			->getOne();
		
		if(is_object($objPayment)) {
			$objPaymentModule = $objPayment->getModuleObject();
			$this->dispatchAction($objPayment, $objPaymentModule);
		}
	}
	function actionProcess() {
		$res = true;
		if($this->_core->getModel('Cart/Collection')->size()<=0) $this->_core->redirect($this->_core->getSingleton('Controller/Cart')->getActionUrl('cart-list'));
		if((int)$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') == 0) {
			$_SESSION['redirect'] = $this->getActionUrl('checkout-confirm');
			$this->_core->redirect($this->_core->getSingleton('Controller/Customer')->getActionUrl('customer-login'));
			return;
		}
		
		$_SESSION['lastpost'] = array_merge($_SESSION['lastpost'], $this->_core->getRequestPost());
		foreach($_SESSION['lastpost'] as $k=>$v) {
			if(!is_array($v)) {
				$_SESSION['lastpost'][$k] = htmlspecialchars($v);
			}
		}
		if(!$_SESSION['checkout']['method']) $this->_core->redirect($this->getActionUrl('checkout-index'));

		$objPayment = $this->_core->getModel('Payment/Collection')
			->addFilter('id', $_SESSION['checkout']['method']['id'], 'eq')
			->getOne();

		if(is_object($objPayment)) {
			$objPaymentModule = $objPayment->getModuleObject();
			$res = $this->dispatchAction($objPayment, $objPaymentModule);
		}
//		die('<pre>'.print_r($objPayment->getModuleObject(),1).'</pre>');
	}
	function finish(& $order) {
		if(Core::getModel('Cart')->size()<=0) $this->_core->redirect('/cart/list');
		if((int)$this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('id') == 0) {
			$_SESSION['redirect'] = $this->getActionUrl('checkout-confirm');
			$this->_core->redirect($this->_core->getSingleton('Controller/Customer')->getActionUrl('customer-login'));
			return;
		}
		$this->_core->assign('arrProducts', $this->_core->getModel('Cart')->getProducts());
		$template = $this->_core->getModel('Template/Collection')->newInstance()
				->addFilter('code', 'EMAIL_ORDER_COMPLETE', 'eq')
				->getOne(false, true, true);
		$order->export();
		$order->fillProducts();
		$template->push('order', $order);
		$template->push('customer', $this->_core->getModel('Customer/Collection')->getCurrentCustomer());
		$subj = $template->get('title');
		$body = $template->get('content');
		$email = $this->_core->getModel('Email')->newInstance();
//		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('email')) {
//			$this->_core->getModel('Email')->send($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('email'),$subj,$body,false);
//		}
//		$this->_core->getModel('Email')->send($this->_core->getSingleton('Config')->arrEmail['bccadmin'],$subj,$body,false,false);
		if(!$email->push('template', $template)->push('customer', $this->_core->getModel('Customer/Collection')->getCurrentCustomer())->send()) {
			if($this->_core->getDebug()) {
				$this->_core->raiseError('Email sending error.');
			}
		} else {
			$email = $this->_core->getModel('Email')->newInstance();
			$email->push('template', $template)->push('customer', $this->_core->getModel('Customer/Collection')->getCurrentCustomer());
			if(
				!$email->send(
					$this->_core->getModel('Setting/Collection')->get('ADMINISTRATOR_EMAIL')->get('value'),
					$this->_core->getModel('Setting/Collection')->get('ORDER_EMAIL')->get('value')
				)
			) {
				if($this->_core->getDebug()) {
					$this->_core->raiseError('Email sending error.');
				}
			}
		}
		$this->_core->getModel('Cart')->destroy();
		$this->_core->redirect($this->getActionUrl('checkout-success'));
		unset($_SESSION['checkout']);
		unset($_SESSION['lastpost']);
	}
	function actionNotification() {
		
	}
	function actionSuccess() {
		$this->_core->getBlock('Checkout/Success')->init();
	}
	function actionFailure() {
		$this->_core->getBlock('Checkout/Failure')->init();
	}
	function dispatchAction($objPayment, $objPaymentModule) {
		$this->_core->getSingleton('Model/Payment/Module');
		$_action = strtolower($this->_core->controllerAction);
//		die('<pre>'.print_r($objPaymentModule['controller'],1));
		foreach ( $objPaymentModule['controller']['action'] as $action ) {
			if($action['name']==$_action) {
				if(sizeof($action['class']['method'])>0 && !isset($action['class']['method'][0])) {
					$action['class']['method'] = array($action['class']['method']);
				}
				foreach($action['class']['method'] as $method) {
					if(sizeof($method['attribute'])>0 && !isset($method['attribute'][0])) {
						$method['attribute'] = array($method['attribute']);
					}
					$args = array();
					foreach($method['attribute'] as $attr) {
						$args[$attr['name']] = $$attr['name'];
					}
					$this->_core->getSingleton($action['class']['classname'])->$method['name']($args);
				}
				
				break;
			}
		}
	}
	function prepareUrls() {
		$this->pushUrl('checkout-index', $this->_siteUrl . 'checkout/index');
 		$this->pushUrl('checkout-notification', $this->_siteUrl . 'checkout/notification');
 		$this->pushUrl('checkout-list', $this->_siteUrl . 'checkout/list');
 		$this->pushUrl('checkout-process', $this->_siteUrl . 'checkout/process');
 		$this->pushUrl('checkout-success', $this->_siteUrl . 'checkout/success');
 		$this->pushUrl('checkout-failure', $this->_siteUrl . 'checkout/failure');
 		$this->pushUrl('checkout-prepare', $this->_siteUrl . 'checkout/prepare');
 		$this->pushUrl('checkout-confirm', $this->_siteUrl . 'checkout/confirm');
	}
}
?>