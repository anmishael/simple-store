<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

class Controller_Admin_Filter extends Controller {
	function __construct() {
		parent::__construct();
		$this->prepareUrls();
	}
	function actionIndex() {
		$this->_core->redirect($this->getActionUrl('admin-filter-list'));
	}
	function actionList() {
		$this->_core->getBlock('Admin/Filter/List')->init();
	}
	function actionEdit() {
		$this->_core->getBlock('Admin/Filter/Edit')->init();
	}
	function actionSave() {
		/** @var $item Model_Filter */
		$item = $this->_core->getModel('Filter')->newInstance($this->_core->getRequestPost());
//		$this->_core->setDebug(2);
		$fType = $this->_core->getModel('Filter/Type/Collection')->newInstance()
			->addFilter('id', $item->get('type'), 'eq')
			->getOne(false, true, true);
		if($fType instanceof Model_Filter_Type && $_FILES['image'] && file_exists($_FILES['image']['tmp_name'])) {
			/** @var $file Model_File */
			$file = $this->_core->getModel('File')->newInstance()->setPath($_FILES['image']['tmp_name']);
			$dir = $this->_core->getSingleton('Config')->getUnixPath() . 'images/filters/' . $fType->get('url') . '/';
			$sdir = 'images/filters/' . $fType->get('url') . '/';
			if($file->moveUploaded($_FILES['image']['tmp_name'], $dir . $_FILES['image']['name'])) {
				$item->push('image', '/' . $sdir . $_FILES['image']['name']);
			} else {
				$this->_core->raiseError('Could not move "' . $_FILES['image']['tmp_name'] . '" to "' . $dir . $_FILES['image']['name'] . '".');
			}
		}
		if($item->save()) {
			$this->_core->redirect($this->getActionUrl('admin-filter-list') . '?typeid=' . $item->get('type'));
		}
//		$this->_core->setDebug(0);
	}
	function actionRemove($type = null) {
		if($type instanceof Model_Product) {
			$filters = $product->fetchFilters()->get('filters');
			foreach($filters as $filter) {
				$filter->remove();
			}
		} elseif($this->_core->getRequest('id')) {
			$item = $this->_core->getModel('Filter/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($item->remove()) {
				$this->_core->redirect($this->getActionUrl('admin-filter-list'));
			} else {
				$this->_core->raiseError('Missig filter with "'.$this->_core->getRequest('id').'" id.');
			}
		}
	}
	function actionType() {
		$this->_core->redirect($this->getActionUrl('admin-filter-type-list'));
	}
	function actionTypeList() {
		$this->_core->getBlock('Admin/Filter/Type/List')->init();
	}
	function actionTypeEdit() {
		$this->_core->getBlock('Admin/Filter/Type/Edit')->init();
	}
	function actionTypeSave() {
		/** @var $item Model_Filter_Type */
		$item = $this->_core->getModel('Filter/Type')->newInstance($this->_core->getRequestPost());
		if($item->save()) {
			$this->_core->redirect($this->getActionUrl('admin-filter-type-list'));
		}
	}
	function actionStatus() {
		if($this->_core->getRequest('id')) {
			$item = $this->_core->getModel('Filter/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($item instanceof Model_Filter) {
				if((int)$item->get('status') == 1) {
					$item->set('status', 0);
				} else {
					$item->set('status', 1);
				}
				$item->save();
			} else {
				$this->_core->raiseError('Missing filter for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Filter/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Filter/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Filter/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-filter-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing filter ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-filter-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}
	function actionTypeStatus() {
		if($this->_core->getRequest('id')) {
			$item = $this->_core->getModel('Filter/Type/Collection')->newInstance()
				->addFilter('id', $this->_core->getRequest('id'), 'eq')
				->getOne();
			if($item instanceof Model_Filter_Type) {
				if((int)$item->get('status') == 1) {
					$item->set('status', 0);
				} else {
					$item->set('status', 1);
				}
				$item->save();
			} else {
				$this->_core->raiseError('Missing filter type for that ID');
			}
			if($this->_core->doctype) {
				if(is_object($this->_core->getBlock('Admin/Filter/Type/Status/' . ucfirst($this->_core->doctype)))) {
					$this->_core->getBlock('Admin/Filter/Type/Status/' . ucfirst($this->_core->doctype))->init();
				} else {
					$this->_core->raiseError('Missing object "'.'Block/Admin/Filter/Type/Status/' . ucfirst($this->_core->doctype).'"');
				}
			} else {
				$this->_core->redirect($this->getActionUrl('admin-filter-type-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		} else {
			$this->_core->raiseError('Missing filter type ID');
			if(!$this->_core->doctype) {
				$this->_core->redirect($this->getActionUrl('admin-filter-type-list') . '?' . $this->_core->getAllGetParams(array('id')));
			}
		}
	}
	function actionTypeRemove() {
		$item = $this->_core->getModel('Filter/Type/Collection')->newInstance()
			->addFilter('id', $this->_core->getRequest('id'), 'eq')
			->getOne();
		if($item->remove()) {
			$this->_core->redirect($this->getActionUrl('admin-filter-type-list'));
		}
	}
	function prepareUrls() {
		$this->pushUrl('admin-filter-list', $this->_adminUrl . 'filter/list');
		$this->pushUrl('admin-filter-edit', $this->_adminUrl . 'filter/edit');
		$this->pushUrl('admin-filter-save', $this->_adminUrl . 'filter/save');
		$this->pushUrl('admin-filter-remove', $this->_adminUrl . 'filter/remove');
		$this->pushUrl('admin-filter-type-list', $this->_adminUrl . 'filter/type/list');
		$this->pushUrl('admin-filter-type-edit', $this->_adminUrl . 'filter/type/edit');
		$this->pushUrl('admin-filter-type-save', $this->_adminUrl . 'filter/type/save');
		$this->pushUrl('admin-filter-type-remove', $this->_adminUrl . 'filter/type/remove');
		return $this;
	}
}