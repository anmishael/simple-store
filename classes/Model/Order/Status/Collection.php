<?php
/**
 * Created on 16 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Model_Order_Status_Collection extends Model_Collection_Abstract {
	var $_table = 'order_statuses';
	var $_id = 'id';
	var $_model = 'Order/Status';
}