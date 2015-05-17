<?php
/**
 * List.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 13.01.13
 * Time: 13:46
 */
class Block_Admin_Product_Review_List extends Block_Display {
	var $_items;
	var $_limit = 10;
	function init() {
		$this->_items = $this->_core->getModel('Product/Review/Collection')
			->newInstance()
			->setOrder('added')
			->setOrderWay('DESC')
			->setLimit(($this->_page-1)*$this->_limit . ', ' . $this->_limit)
			->getCollection();
		$this->_totalpages = $this->_core->getModel('Product/Review/Collection')->newInstance();
		$this->_totalpages = ceil($this->_totalpages->getTotal()/$this->_limit);

		if($this->_core->getModel('User/Collection')->getCurrentUser()->checkPermission('Product', 'ReviewStatus')) {
			$this->_actions[] = array(
				'url'=>$this->_core->getActionUrl('admin-product-review-status'),
				'name'=>$this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value')
			);
		}
		$this->fetch('product', 'review/list');
		return $this;
	}
}
