<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 29.03.13
 * Time: 9:11
 * To change this template use File | Settings | File Templates.
 */
class Block_Admin_Customer_Import extends Block_Display {
	var $_tmpFile = '/admin/tmp/customer-import.txt';
	function init() {
		$ext = array('xml');
		$path = $this->_core->getSingleton('Config')->dbPath . 'customer/';
		$d = dir($path);
		while( ($entry = $d->read())!=false ) {
			if(is_file($path . $entry)) {
				$pinfo = pathinfo($entry);
				if(in_array($pinfo['extension'], $ext)) {
					/** @var $file Model_File */
					$file = $this->_core->getModel('File')->newInstance()->setPath($path . $entry);
					$mime = $file->fetchMime()->get('mime');
					$size = $file->human_filesize();
					$this->_items[] = array('path'=>$path . $entry, 'name'=>$entry, 'size'=>$size, 'mime'=>$mime);
				}
			}
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'ImportFileRemove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-import-file-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Ви впевнені що бажаєте видалити "%s" файл?'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'ImportItemList')) {
			$this->_actions2[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-import-item-list'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_LIST', 'value')->get('value'),
				'class'=>'import-item-list'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'ImportItemClear')) {
			$this->_actions2[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-import-item-clear'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CLEAR', 'value')->get('value'),
				'class'=>'import-item-clear'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Customer', 'ImportItemRollback')) {
			$this->_actions2[] = array(
				'url'=>$this->_core->getActionUrl('admin-customer-import-item-rollback'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ROLLBACK', 'value')->get('value'),
				'class'=>'import-item-rollback',
				'warning'=>'Ви впевнені що бажаєте відмінити імпорт? Ця дія видалить всіх імпортованих клієнтів.'
			);
		}
		$this->_imports = $this->_core->getModel('Import/Collection')->addFilter('model', 'Customer', 'eq')->getCollection();
		$this->fetch('customer', 'import');
		return $this;
	}
}
