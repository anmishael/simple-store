<?php
/*
 * Created on 5 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Model_Product_Image_Collection extends Model_Collection_Abstract {
 	var $_table = 'images';
 	var $_id = 'id';
 	var $_model = 'Product/Image';
 }