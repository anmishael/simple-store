<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Block_Product_Popular_Box extends Block_Display {
	var $_items;
	function init() {
		$this->_limit = 3;
		$this->_blockname = 'contentleft';
		$this->_items = $this->_core->getModel('Product/Collection')->newInstance()
			->addField('IF(p2b.bundle_id IS NULL, CONCAT(RAND(3), \'null\', id), CONCAT(p2b.bundle_id, \'\')) as bundle_ids')
			->addTable('products_to_bundles', 'p2b', array('p2b.bundle_id'), 'p2b.product_id=`products`.id')
			->addFilter('status', 1, 'eq')
			->setGroup('bundle_ids')
			->setOrder('sold')
			->setOrderWay('DESC')
			->setLimit($this->_limit)
			->getCollection(false, true, true);
		if(sizeof($this->_items)>0) {
			$this->fetch('product', 'popular/box');
		}
		return $this;
	}
}