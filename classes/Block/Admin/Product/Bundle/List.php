<?php
/**
 * List.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 18.02.13
 * Time: 18:01
 */
class Block_Admin_Product_Bundle_List extends Block_Display {
	var $_items;
	var $_columns = array();
	var $_url = 'product/bundle/list';
	var $_id_part = 'bundle-list';
	function init() {
		$coll = $this->_core->getModel('Product/Bundle/Collection')->newInstance();
		$this->_totalpages = clone($coll);
		$coll->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit);
		$this->_totalpages = ceil($this->_totalpages->getTotal()/$this->_limit);
		$this->_items = $coll->getCollection();
		$this->_columns = array(
			array(
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ID', 'value')->get('value'),
				'field'=>'pbid'
			),
			array(
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'),
				'field'=>'name'
			),
			array(
				'title'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'),
				'field'=>'code'
			)
		);
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'BundleEdit')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-bundle-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EDIT', 'value')->get('value')
			);
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-bundle-remove'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_REMOVE', 'value')->get('value')
			);
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-bundle-edit'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ADD_NEW_PRODUCT_BUNDLE', 'value')->get('value')
			);
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'List')) {
			$this->_toplinks[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-list'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PRODUCT_LIST', 'value')->get('value')
			);
		}
		$this->fetch('product', 'bundle/list');
	}
}
