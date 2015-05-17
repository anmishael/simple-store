<?php
/*
 * Created on May 18, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Controller_Product extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareUrls();
	}
	function actionIndex() {
//		$this->actionList();
		$this->_core->redirect($this->getActionUrl('product-list'));
	}
	function actionList() {
		if($this->_core->doctype) {
			if($this->_core->getRequest('block') && is_object($this->_core->getBlock('Product/'.$this->_core->getRequest('block').'/'.ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Product/'.$this->_core->getRequest('block').'/'.ucfirst($this->_core->doctype))->init();
			} else {
				$this->_core->getBlock('Product/List/' . ucfirst($this->_core->doctype));
			}
		} else {
			$this->_core->getSingleton('View')->addOutput('title', 'Product\'s list.');
			$this->_core->getBlock('Product/List')->init();
		}
	}
	function actionView() {
		if($this->_core->getRequest('id')) {
			if($this->_core->doctype && $this->_core->getBlock('Product/View/' . ucfirst($this->_core->doctype))) {
				$this->_core->getBlock('Product/View/' . ucfirst($this->_core->doctype))->init();
			} else {
				$this->_core->getBlock('Product/View')->init();
			}
		}
	}
	function actionFavoriteView() {

	}
	function actionFavoriteAdd() {
		if($this->_core->getRequest('id')) {
			if( ($_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer()) && $_customer instanceof Model_Customer && $_customer->get('id')) {
				$_favorite = $this->_core->getModel('Product/Favorite/Collection')->newInstance()
					->addFilter('pid', $this->_core->getRequest('id'), 'eq')
					->addFilter('cid', $_customer->get('id'), 'eq')
					->getOne();
				if(!$_favorite instanceof Model_Product_Favorite) {
					$_favorite = $this->_core->getModel('Product/Favorite')->newInstance();
					$_favorite->push('pid', $this->_core->getRequest('id'));
					$_favorite->push('cid', $_customer->get('id'));
					if($_favorite->save()) {
						if($this->_core->doctype) {
							$this->_core->getBlock('Product/Favorite/Add/' . ucfirst($this->_core->doctype))->init();
						} else {
							$link = $_SERVER['HTTP_REFERER'];
							$this->_core->redirect($link);
//	 						$this->_core->getBlock('Product/Favorite/View')->init();
						}
					}
				} else {
					$this->_core->raiseError('Product is already in favorites');
					if($this->_core->doctype) {
						$this->_core->getBlock('Product/Favorite/Add/' . ucfirst($this->_core->doctype))->init();
					}
				}
			} else {
				if(!isset($_SESSION['favorites'])) {
					$_SESSION['favorites'] = array();
				}
				if(in_array($this->_core->getRequest('id'), $_SESSION['favorites'])) {
					$this->_core->raiseError('Product is already in favorites');
				} else {
					$_SESSION['favorites'][$this->_core->getRequest('id')] = $this->_core->getRequest('id');
					if($this->_core->doctype) {
						$this->_core->getBlock('Product/Favorite/Add/' . ucfirst($this->_core->doctype))->init();
					}
				}
			}
		} elseif(($_customer = $this->_core->getModel('Customer/Collection')->newInstance()->getCurrentCustomer()) && $_customer instanceof Model_Customer && $_customer->get('id') && $_SESSION['favorites']) {
			foreach($_SESSION['favorites'] as $id) {
				$_favorite = $this->_core->getModel('Product/Favorite/Collection')->newInstance()
					->addFilter('pid', $id, 'eq')
					->addFilter('cid', $_customer->get('id'), 'eq')
					->getOne();
				if(!$_favorite instanceof Model_Product_Favorite || !$_favorite->get('id')) {
					$_favorite = $this->_core->getModel('Product/Favorite')->newInstance();
					$_favorite->push('pid', $id);
					$_favorite->push('cid', $_customer->get('id'));
					$_favorite->save();
				}
			}
			unset($_SESSION['favorites']);
		}
	}
	function actionFavoriteRemove() {
		if($this->_core->getRequest('id')) {
			if( ($_customer = $this->_core->getModel('Customer/Collection')->getCurrentCustomer()) && $_customer instanceof Model_Customer && $_customer->get('id')) {
				$_favorite = $this->_core->getModel('Product/Favorite/Collection')->newInstance()
					->addFilter('pid', $this->_core->getRequest('id'), 'eq')
					->addFilter('cid', $_customer->get('id'), 'eq')
					->getOne();
				if($_favorite instanceof Model_Product_Favorite && $_favorite->get('id')) {
					if($_favorite->remove()) {
						if($this->_core->doctype) {

						} else {
							$link = $_SERVER['HTTP_REFERER'];
							$this->_core->redirect($link);
						}
					}
				} else {
					$this->_core->raiseError('That item is missing in your favorites.');
				}
			} else {
				if(in_array($this->_core->getRequest('id'), $_SESSION['favorites'])) {
					unset($_SESSION['favorites'][array_search($this->_core->getRequest('id'), $_SESSION['favorites'])]);
				}
			}
		}
	}
	function actionReview() {

	}
	function actionReviewAdd() {
		if(!$this->_core->notNull($this->_core->getRequestPost('pid'))) {
			$this->_core->raiseError('Missing product id!');
		}
		if(!$this->_core->notNull($this->_core->getRequestPost('email'))) {
			$this->_core->raiseError('Please enter email!');
		}
		if(!$this->_core->notNull($this->_core->getRequestPost('name'))) {
			$this->_core->raiseError('Please enter your name!');
		}
		if(!$this->_core->emailIsValid($this->_core->getRequestPost('email'))) {
			$this->_core->raiseError('Your email does not seems to be valid. Please type another one.');
		}
		if($this->_core->getRequestPost('captcha')!=$this->_core->getRequestSess('captcha')) {
			$this->_core->raiseError('Please enter correct text from image.');
		}
		if($this->_core->getModel('Error/Collection')->size()<=0) {
			$product = $this->_core->getModel('Product/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequestPost('pid'), 'eq')
				->addFilter('status', 1, 'eq')
				->getOne();
			if($product instanceof Model_Product) {
				$data = $this->_core->getRequestPost();
				$data['status'] = 1;
				if(!$product->saveReview($data)) {
					$this->_core->raiseError('Review saving error');
				}
			} else {
				$this->_core->raiseError('Missing product.');
			}
			$this->_core->redirect($this->getActionUrl('product-view') . '?' . $this->_core->getAllGetParams());
		} else {
			$_SESSION['last_post'] = $this->_core->getRequestPost();
			$this->_core->redirect($this->getActionUrl('product-view') . '?' . $this->_core->getAllGetParams());
		}
	}
	function prepareUrls() {
		$this->pushUrl('product-list', $this->_siteUrl . 'product/list');
		$this->pushUrl('product-view', $this->_siteUrl . 'product/view');
		$this->pushUrl('product-edit', $this->_siteUrl . 'product/edit');
		$this->pushUrl('product-save', $this->_siteUrl . 'product/save');
		$this->pushUrl('product-upload', $this->_siteUrl . 'product/upload');
		$this->pushUrl('product-remove', $this->_siteUrl . 'product/remove');

		$this->pushUrl('product-favorite', $this->_siteUrl . 'product/favorite');
		$this->pushUrl('product-favorite-add', $this->_siteUrl . 'product/favorite/add');
		$this->pushUrl('product-favorite-view', $this->_siteUrl . 'product/favorite/view');
		$this->pushUrl('product-favorite-remove', $this->_siteUrl . 'product/favorite/remove');

		$this->pushUrl('product-review', $this->_siteUrl . 'product/review');
		$this->pushUrl('product-review-list', $this->_siteUrl . 'product/review/list');
		$this->pushUrl('product-review-add', $this->_siteUrl . 'product/review/add');

		return $this;
	}
}