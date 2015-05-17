<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Model_Order_Product extends Model_Object {
	var $_table = 'order_products';
	var $_id = 'id';

	function fetchBundles() {
		$bundles = $this->_core->getModel('Product/Bundle/Collection')->newInstance()
			->addTable('products_to_bundles', 'p2b')
			->addFilter('p2b', 'p2b.bundle_id=pbid', 'logic')
			->addFilter('p2b.product_id', $this->get('pid'), 'eq')
			->getCollection();
		if(sizeof($bundles)>0) {
			$this->push('bundles', $bundles);
		}
		return $this;
	}
}