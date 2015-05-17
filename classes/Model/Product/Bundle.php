<?php
/**
 * Bundle.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 18.02.13
 * Time: 14:40
 */
class Model_Product_Bundle extends Model_Object {
	var $_table = 'product_bundles';
	var $_id = 'pbid';
	var $_model = 'Product/Bundle';
	function fetchProducts($filters = array(), $status = null) {
		$coll = $this->_core->getModel('Product/Collection')->newInstance()
			->addTable('products_to_bundles', 'p2b')
			->addFilter('p2b.bundle_id', $this->get($this->_id), 'eq')
			->addFilter('p2b', 'p2b.product_id=products.id', 'logic');
		if($status!=null) {
			$coll->addFilter($coll->_table . '.status', $status, 'eq');
		}
		if($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield')) {
			$coll->addField($this->_core->getModel('Customer/Collection')->getCurrentCustomer()->get('pricegroupfield') . ' AS price');
		}
		if($filters['min-price'] && $filters['min-price']>0) {
			$coll->addGroupFilter('price', 'price', $filters['min-price'], 'moreeq');
		}
		if($filters['max-price'] && $filters['max-price']>0) {
			$coll->addGroupFilter('price', 'price', $filters['max-price'], 'lesseq');
		}
		$this->push('products', $coll->getCollection(false, true, true));
		return $this;
	}

	/**
	 * @param $product integer|Model_Product
	 * @return Model_Product_Bundle
	 */
	function detachProduct($product) {
		if($product instanceof Model_Product) {
			$product = $product->get($product->_id);
		}
		if(is_numeric($product)) {
			$obj = $this->_core->getModel('Collection')->newInstance()
				->addFilter('product_id', $product, 'eq')
				->addFilter('bundle_id', $this->get($this->_id), 'eq');

			$res = $this->_core->getResource('DB')->getConnection()->remove('products_to_bundles', $obj);
		}
		return $this;
	}
	function appendProduct($product) {
		if($product instanceof Model_Product) {
			$product = $product->get($product->_id);
		}
		if(is_numeric($product)) {
			$data = array(
				'product_id'=>$product,
				'bundle_id'=>$this->get($this->_id)
			);
			$res = $this->_core->getResource('DB')->getConnection()->insert('products_to_bundles', $data);
		} else {
			$this->_core->raiseError('Could not append product. Incorrect ID: "'.print_r($product,1).'"');
		}
		return $this;
	}
	function appendProducts($products) {
		foreach($products as $k=>$v) {
			$this->appendProduct($v);
		}
		return $this;
	}
	function disconnect($object) {
		$res = false;
		if($object instanceof Model_Product) {
			$sql = 'DELETE FROM `products_to_bundles` WHERE product_id=\'' . $object->get($object->_id) . '\' AND bundle_id=\''.$this->get($this->_id).'\'';
			if(!($res = $this->_core->getResource('DB')->getConnection()->setQuery($sql)->query())) {
				$this->_core->raiseError('Cannot disconnect "'.$this->get('id').'" bundle from "'.$object->get('code').'" product.');
			}
		}
		return $res;
	}
	function save($force = false) {
		parent::save($force);
		if(sizeof($this->get('products'))>0) {
			$products = $this->get('products');
			foreach($products as $k=>$product) {
				if($product instanceof Model_Product) {
					$data = array('product_id'=>$product->get($product->_id), 'bundle_id'=>$this->get($this->_id));
					$this->_core->getResource('DB')->getConnection()->insert('products_to_bundles', $data);
				}
			}
		}
	}
}
