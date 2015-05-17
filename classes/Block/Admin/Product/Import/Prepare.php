<?php
/**
 * Separator.php
 * Created by mikel <anmishael@gmail.com>
 * Support: WIDE Software Team <support@widesoftware.com>
 * Date: 14.02.13
 * Time: 17:40
 */
class Block_Admin_Product_Import_Prepare extends Block_Display {
	var $_tmpFile = '/admin/tmp/product-import.txt';
	function init($data) {
		$this->_path = $data['path'];
		$this->_sep = $data['sep'];
		$this->_cols = $data['cols'];
		$this->_arrSep = array(',', ';');
		$this->_record = $this->_core->getRequest('record');
		$this->_fields = array(
			'code'=>'Code',
			'sku'=>'SKU',
			'bundle_name'=>'Bundle Name',
			'name'=>'Product Name',
			'price'=>'Price',
			'packing'=>'Packing',
			'brand'=>'Brand',
			'image'=>'Image',
			'shortdesc'=>'Short Description',
			'description'=>'Description',
			'logo'=>'Logo',
			'additional'=>'Additional'
		);
		$this->fetch('product', 'import/prepare');
		return $this;
	}
}
