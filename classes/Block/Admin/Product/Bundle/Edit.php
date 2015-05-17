<?php
/**
 * Edit.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 18.02.13
 * Time: 21:03
 */
class Block_Admin_Product_Bundle_Edit extends Block_Display {
	var $_item;
	function init() {
		$this->_action = $this->_core->getSingleton('Controller/Admin/Product')->getActionUrl('admin-product-bundle-save');
		$this->_action_back = $this->_core->getSingleton('Controller/Admin/Product')->getActionUrl('admin-product-bundle-list');
		$this->_columns = array(
			array(
				'title'=>'Назва',
				'field'=>'name'
				),
			array(
				'title'=>'Код',
				'field'=>'code'
			)
		);
		if($this->_core->getRequest('id')) {
			$this->_item = $this->_core->getModel('Product/Bundle/Collection')->newInstance()
				->addFilter('pbid', $this->_core->getRequest('id'), 'eq')
				->getOne();
		}
		if(!$this->_item instanceof Model_Product_Bundle) {
			$this->_item = $this->_core->getModel('Product/Bundle')->newInstance();
		}
		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'BundleDetach')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-bundle-detach'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DETACH', 'value')->get('value'),
				'warning'=>'Are you sure you wish to detach "%s" product from bundle?'
			);
		}
		$this->_item->fetchProducts();
//		print_r($this->_item);
//		$this->fetch('default', 'edit');
		$this->fetch('product', 'bundle/edit');
	}
}
