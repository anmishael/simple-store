<?php
/**
 * Created on 20 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 class Model_Customer_Support_Message_Collection extends Model_Collection_Abstract {
 	var $_table = 'customer_support_messages';
 	var $_id = 'id';
 	var $_model = 'Customer/Support/Message';
 }