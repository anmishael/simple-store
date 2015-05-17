<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 
class Model_Order_Product_Collection extends Model_Collection_Abstract {
	var $_table = 'order_products';
	var $_id = 'id';
	var $_model = 'Order/Product';
}