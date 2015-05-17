<?php
/**
 * Created on 5 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @version 1.0
 */
 
 
class Block_Admin_Product_Import extends Block_Display {
	var $_items = array();
	var $_imports = array();
	var $_actions2 = array();
	var $_tmpFile = '/admin/tmp/product-import.txt';
	function init() {
		$ext = array('xml', 'csv');
		$path = $this->_core->getSingleton('Config')->dbPath . 'product/';
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
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImportRemove')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-import-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value'),
				'warning'=>'Are you sure you wish to remove "%s" product?'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImportItemList')) {
			$this->_actions2[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-import-item-list'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_LIST', 'value')->get('value'),
				'class'=>'import-item-list'
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ImportItemRollback')) {
			$this->_actions2[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-import-item-rollback'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ROLLBACK', 'value')->get('value'),
				'class'=>'import-item-rollback',
				'warning'=>'Ви впевнені що бажаєте відмінити імпорт? Ця дія видалить всі імпортовані товари.'
			);
		}
		$this->_imports = $this->_core->getModel('Import/Collection')->addFilter('model', 'Product', 'eq')->getCollection();
		$this->fetch('product', 'import');
		return $this;
	}
}