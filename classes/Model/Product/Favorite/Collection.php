<?php
/**
 * Created on 31 лип. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Model_Product_Favorite_Collection extends Model_Collection_Abstract {
 	var $_table = 'product_favorites';
 	var $_id = 'id';
 	var $_model = 'Product/Favorite';
 }