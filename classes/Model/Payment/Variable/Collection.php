<?php
/**
 * Created on 12 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
class Model_Payment_Variable_Collection extends Model_Collection_Abstract {
	var $_table = 'payment_variables';
	var $_id = 'name';
	var $_model = 'Payment/Variable';
}