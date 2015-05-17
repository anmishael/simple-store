<?php
/**
 * File: Order.php
 * Created on 8 лют. 2011
 *
 *
 * @category   
 * @package    
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

class Model_Order extends Model_Object {
	var $_table = 'orders';
	var $_id = 'id';
	var $_model = 'Order';
	function fillProducts() {
// 		die(print_r(Core::getResource('Order/Collection')->getOrderDetails($this),1));
		$this->push('products', $this->_core->getModel('Order/Product/Collection')->newInstance()->addFilter('oid', $this->get('id'), 'eq')->getCollection());
		return $this;
	}
	function fetchProducts() {
		$this->fillProducts();
		return $this;
	}
	function save() {
		parent::save();
		if($this->get($this->_id)>0) {
			$cart = $this->get('cart');
			if(sizeof($cart)>0) {
				foreach($cart as $k=>$v) {
					$data = array(
						'oid'=>$this->get('id'),
						'pid'=>$v->get('id'),
						'sku'=>$v->get('sku'),
						'name'=>$v->get('name'),
						'price'=>$v->get('price'),
						'qty'=>(int)$v->get('qty')>0?$v->get('qty'):1,
						'total'=>$v->get('price')*((int)$v->get('qty')>0?$v->get('qty'):1),
						'code'=>$v->get('code')
					);
					if(!
					$this->_core->getModel('Order/Product')->newInstance($data)->save()
						) {
						die('Could not save <pre>'.print_r($data,1).'</pre>');
					}
				}
			}
		}
		return $this->get($this->_id);
	}
	function export() {
		if($this->get($this->_id)>0) {
//			die('<pre>'.print_r($this->toArray(),1));
			$fo = fopen($this->_core->getSingleton('Config')->dbPath . 'order/order-' . $this->get($this->_id) . '.xml', 'w');
			fwrite($fo, '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n<order>\n");
			$data = $this->toArray();
			foreach($data as $k=>$v) {
				if(!is_array($v)) {
					fwrite($fo, "\t".'<'.$k.'>'.(is_numeric($v)?$v:'<![CDATA['.$v.']]>').'</'.$k.'>' . "\n");
				}
			}
			$products = $this->fetchProducts()->get('products');
			fwrite($fo, "\t<products>\n");
			foreach($products as $product) {
				fwrite($fo, "\t\t<product>\n");
				fwrite($fo, "\t\t\t<code>".$product->get('code')."</code>\n");
				fwrite($fo, "\t\t\t<qty>".$product->get('qty')."</qty>\n");
				fwrite($fo, "\t\t\t<price>".$product->get('price')."</price>\n");
				fwrite($fo, "\t\t\t<total>".$product->get('total')."</total>\n");
				fwrite($fo, "\t\t</product>\n");
			}
			fwrite($fo, "\t</products>\n");
			fwrite($fo, "</order>\n");
			fclose($fo);
		}
		return $this;
	}
	//*/
}
?>