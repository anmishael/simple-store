<?php
/*
 * Created on May 28, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Controller_Admin_Customer extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareUrls();
	}
	function actionIndex() {
		$this->_core->redirect($this->getActionUrl('admin-customer-list'));
	}
	function actionList() {
		$this->_core->getBlock('Admin/Customer/List')->init();
	}
	function actionEdit() {
		$this->_core->getBlock('Admin/Customer/Edit')->init();
	}
	function actionSave() {
		if($this->_core->getRequestPost() && sizeof($this->_core->getRequestPost())>0) {
			$this->_core->getModel('Customer');
			$customer = new Model_Customer($this->_core->getRequestPost());
			$customer->save();
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-list'));
	}
	function actionStatus() {
		if($this->_core->getRequest('id')) {
			$customer = $this->_core->getModel('Customer/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($customer instanceof Model_Customer) {
				if((int)$customer->get('status') == 1) {
					$customer->set('status', 0);
				} else {
					$customer->set('status', 1);
				}
				$customer->save();
			} else {
				$this->_core->raiseError('Missing client for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Customer/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Customer/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Customer/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-customer-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing customer ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-customer-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}

	function actionRemove() {
		$customer = $this->_core->getModel('Customer/Collection')
			->clear()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if($customer instanceof Model_Customer) {
			$customer->remove();
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-list'));
	}
	function actionImport() {
		$path = $this->_core->getSingleton('Config')->dbPath . 'customer/';
		if(!file_exists($path)) {
			$this->_core->mkFolders($path);
		}
		$uploaded = false;
		if(
			$_FILES['import'] &&
			is_uploaded_file($_FILES['import']['tmp_name'])
		) {
			if(move_uploaded_file($_FILES['import']['tmp_name'], $path . $_FILES['import']['name'])) {
//				$uploaded = true;
//				echo $path . $_FILES['import']['name'];
//				$this->_core->redirect($this->getActionUrl('admin-customer-import').'?path='.$path.$_FILES['import']['name']);
				$this->_core->redirect($this->getActionUrl('admin-customer-import'));
			} else {
				$this->_core->raiseError('Could not move uploaded file into "'.$path . $_FILES['import']['name'].'".');
			}
		}
		if(
//			$uploaded
//			||
			$this->_core->getRequest('path')
		) {
			ini_set('memory_limit', '64M');
			set_time_limit(0);
			$pathFolder = $path;
			$path = $_FILES['import']?$path . $_FILES['import']['name']:$this->_core->getRequest('path');

			$mime = $this->_core->getModel('File')->newInstance()->setPath($path)->fetchMime()->get('mime');
			$cType = $this->_core->getModel('Customer/Type/Collection')->newInstance()
				->addFilter('name', 'Registered', 'eq')
				->getOne();
			if(!$cType instanceof Model_Customer_Type) {
				die('Please add customer type called "Registered"');
			}
			switch ($mime) {
				case 'application/xml':
				case 'text/xml':
					require_once('XML/Unserializer.php');
					$options = array(
						XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE=>false,
						XML_UNSERIALIZER_OPTION_ATTRIBUTES_ARRAYKEY=>true
					);
					$obj = new XML_Unserializer($options);

					$res = $obj->unserialize($path, true);
					if(PEAR::isError($res)) {
						die('Error [' . $res->getCode().']'. ':' . $res->getMessage());
					}
					$res = $obj->getUnserializedData();
					if(!isset($res['client'][0])) {
						$import = $this->_core->getModel('Import')->newInstance()
							->push('model', 'Customer')
							->push('filename', $this->_core->getRequest('path'));
						$import->save();

						$item = $this->_core->getModel('Import/Item')->newInstance()
							->push('import_id', $import->get($import->_id))
							->push('code', $client['cardcode']);
						$client = $res['client'];
						$cl = $this->_core->getModel('Customer/Collection')->newInstance()
							->addFilter('cardcode', $client['cardcode'], 'eq')
							->getOne();
						if(!$cl instanceof Model_Customer || !$cl->get('id')) {
							$cl = $this->_core->getModel('Customer')->newInstance();
							$cl->push('cardcode', $client['cardcode'])
								->push('email', $client['email'])
								->push('name_first', $client['name_first'])
								->push('name_last', $client['name_last'])
								->push('address1', $client['address1'])
								->push('address2', $client['address2'])
								->push('phone', $client['phone'])
								->push('city', $client['city'])
								->push('state', $client['state']);
							if($cl->save()) {
								$item->push('item_id', $cl->get($cl->_id))->push('type', 'insert');
								$item->push('result', 'updated');
							} else {
								$item->push('result', 'fail');
							}
							$item->save();
						}
					} else {
						$import = $this->_core->getModel('Import')->newInstance()
							->push('model', 'Customer')
							->push('filename', $this->_core->getRequest('path'));
						$import->save();
						$csize = sizeof($res['client']);
						$timestamp = time();
						$tpath = $this->_core->getSingleton('Config')->adminTmp . 'customer-import.txt';

						$i=0;
						foreach($res['client'] as $client) {
							$item = $this->_core->getModel('Import/Item')->newInstance()
								->push('import_id', $import->get($import->_id))
								->push('type', 'import')
								->push('code', $client['cardcode']);
							$cl = $this->_core->getModel('Customer/Collection')->newInstance()
								->addFilter('cardcode', $client['cardcode'], 'eq')
								->getOne();
							if(!$cl instanceof Model_Customer || !$cl->get('id')) {
								$item->push('type', 'insert');
								$cl = $this->_core->getModel('Customer')->newInstance();
								$cl->push('cardcode', $client['cardcode'])
									->push('email', $client['email'])
									->push('name_first', $client['name_first'])
									->push('name_last', $client['name_last'])
									->push('address1', $client['address1'])
									->push('address2', $client['address2'])
									->push('phone', $client['phone'])
									->push('city', $client['city'])
									->push('state', $client['state'])
									->push('typeid', $cType->get($cType->_id));
								if($cl->save()) {
									$item->push('item_id', $cl->get($cl->_id));
									$item->push('result', 'inserted');
								} else {
									$item->push('result', 'fail');
								}
								$item->save();
							}
							$i++;
							if($i%200) {
								$ctimestamp = time();
								$this->_core->getModel('Track')->newInstance( array(
										'path'=>$tpath,
										'added'=>$timestamp,
										'updated'=>$ctimestamp,
										'records'=>$csize,
										'current'=>$i
									))->save();
							}
						}
						$ctimestamp = time();
						$this->_core->getModel('Track')->newInstance( array(
							'path'=>$tpath,
							'added'=>$timestamp,
							'updated'=>$ctimestamp,
							'records'=>$csize,
							'current'=>$i
						))->save();
					}
					break;
					break;
				default:
					break;
			}
			$this->_core->redirect($this->getActionUrl('admin-customer-import'));
		} else {
			$this->_core->getBlock('Admin/Customer/Import')->init();
		}
	}
	function actionImportFileRemove() {
		if($this->_core->getRequest('filename') && file_exists($this->_core->getRequest('filename')) && is_file($this->_core->getRequest('filename'))) {
			if(!unlink($this->_core->getRequest('filename'))) {
				$this->_core->raiseError('Could not remove file "'.$this->_core->getRequest('filename').'"');
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-import'));
	}
	function actionImportItemList() {
		if($this->_core->doctype) {
			if(is_object($this->_core->getBlock('Admin/Customer/Import/Item/List/' . ucfirst($this->_core->doctype)))) {
				$this->_core->getBlock('Admin/Customer/Import/Item/List/' . ucfirst($this->_core->doctype))->init();
			}
		}
	}
	function actionImportItemClear() {
		if($this->_core->getRequest('iid')) {
			$import = $this->_core->getModel('Import/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('iid'), 'eq')
				->getOne();
			if($import instanceof Model_Import) {
				$items = $this->_core->getModel('Import/Item/Collection')->newInstance()
					->addFilter('import_id', $import->get($import->_id), 'eq')
					->fetchCollection()
					->removeFromDb();
				$import->remove();
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-import'));
	}
	function actionImportItemRollback() {
		if($this->_core->getRequest('iid')) {
			$import = $this->_core->getModel('Import/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('iid'), 'eq')
				->getOne();
			if($import instanceof Model_Import) {
				set_time_limit(0);
				$arrResults = array('imported');
				$items = $this->_core->getModel('Import/Item/Collection')->newInstance()
					->addFilter('import_id', $import->get($import->_id), 'eq')
					->getCollection();
				foreach($items as $item) {
					if(in_array($item->get('result'), $arrResults)) {
						$customer = $this->_core->getModel('Customer/Collection')->newInstance()
							->addFilter('id', $item->get('item_id'), 'eq')
							->getOne();
						if($customer instanceof Model_Customer) {
							$this->_core->dispatchEvent('customer-remove-before', $customer);
							$customer->remove();
							$this->_core->dispatchEvent('customer-remove-after', $customer);
						}
					}
					$item->remove();
				}
				$import->remove();
			}
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-import'));
	}
	function actionType() {
		$this->_core->redirect($this->getActionUrl('admin-customer-type-list'));
	}
	function actionTypeList() {
		$this->_core->getBlock('Admin/Customer/Type/List')->init();
	}
	function actionTypeEdit() {
		$this->_core->getBlock('Admin/Customer/Type/Edit')->init();
	}
	function actionTypeSave() {
		$this->_core->getModel('Customer/Type');
		$type = new Model_Customer_Type($this->_core->getRequestPost());
		if($type->save()) {
			$this->_core->redirect($this->getActionUrl('admin-customer-type-list'));
		}
	}
	function actionTypeRemove() {
		$customer = $this->_core->getModel('Customer/Type/Collection')
			->clear()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if($customer instanceof Model_Customer_Type) {
			$customer->remove();
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-type-list'));
	}
	function actionPricegroup() {
		$this->_core->redirect($this->getActionUrl('admin-customer-pricegroup-list'));
	}
	function actionPricegroupList() {
		$this->_core->getBlock('Admin/Customer/Pricegroup/List')->init();
	}
	function actionPricegroupEdit() {
		$this->_core->getBlock('Admin/Customer/Pricegroup/Edit')->init();
	}
	function actionPricegroupSave() {
		$type = $this->_core->getModel('Customer/Pricegroup')->newInstance($this->_core->getRequestPost());
		$cols = $this->_core->getResource('DB')->getConnection()->getTableColumns('products');
		if($this->_core->getRequestPost('field')) {
			$res = true;
			if(!in_array($this->_core->getRequestPost('field'), $cols)) {
				$res = $this->_core->getResource('DB')->getConnection()->addRow('products', $this->_core->getRequestPost('field'), 'DECIMAL(10,4)');
			}
			if($res) {
				$type->save();
			}
			$this->_core->redirect($this->getActionUrl('admin-customer-pricegroup-list'));
		}
	}
	function actionPricegroupRemove() {
		$customer = $this->_core->getModel('Customer/Pricegroup/Collection')
			->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if($customer instanceof Model_Customer_Pricegroup) {
			$customer->remove();
		}
		$this->_core->redirect($this->getActionUrl('admin-customer-pricegroup-list'));
	}
	function prepareUrls() {
		$this->pushUrl('admin-customer', $this->_adminUrl . 'customer');
		$this->pushUrl('admin-customer-list', $this->_adminUrl . 'customer/list');
		$this->pushUrl('admin-customer-edit', $this->_adminUrl . 'customer/edit');
		$this->pushUrl('admin-customer-save', $this->_adminUrl . 'customer/save');
		$this->pushUrl('admin-customer-remove', $this->_adminUrl . 'customer/remove');
		$this->pushUrl('admin-customer-import', $this->_adminUrl . 'customer/import');
		$this->pushUrl('admin-customer-import-item-list', $this->_adminUrl . 'customer/import/item/list');
		$this->pushUrl('admin-customer-import-item-clear', $this->_adminUrl . 'customer/import/item/clear');
		$this->pushUrl('admin-customer-import-item-rollback', $this->_adminUrl . 'customer/import/item/rollback');
		$this->pushUrl('admin-customer-import-file-remove', $this->_adminUrl . 'customer/import/file/remove');
		$this->pushUrl('admin-customer-type', $this->_adminUrl . 'customer/type');
		$this->pushUrl('admin-customer-type-list', $this->_adminUrl . 'customer/type/list');
		$this->pushUrl('admin-customer-type-edit', $this->_adminUrl . 'customer/type/edit');
		$this->pushUrl('admin-customer-type-save', $this->_adminUrl . 'customer/type/save');
		$this->pushUrl('admin-customer-type-remove', $this->_adminUrl . 'customer/type/remove');
		$this->pushUrl('admin-customer-pricegroup', $this->_adminUrl . 'customer/pricegroup');
		$this->pushUrl('admin-customer-pricegroup-list', $this->_adminUrl . 'customer/pricegroup/list');
		$this->pushUrl('admin-customer-pricegroup-edit', $this->_adminUrl . 'customer/pricegroup/edit');
		$this->pushUrl('admin-customer-pricegroup-save', $this->_adminUrl . 'customer/pricegroup/save');
		$this->pushUrl('admin-customer-pricegroup-remove', $this->_adminUrl . 'customer/pricegroup/remove');
		return $this;
	}
}