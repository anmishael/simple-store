<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 23.03.13
 * Time: 15:31
 * To change this template use File | Settings | File Templates.
 */

class Model_Import_Item_Collection extends Model_Collection_Abstract {
	var $_table = 'import_history_to_items';
	var $_id = 'id';
	var $_model = 'Import/Item';
}