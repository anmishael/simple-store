<?php
/**
 * Created on 7 серп. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Model_Customer_Message_Collection extends Model_Collection_Abstract {
 	var $_table = 'customer_messages';
 	var $_id = 'id';
 	var $_model = 'Customer/Message';
 }