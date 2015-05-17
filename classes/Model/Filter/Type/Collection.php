<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Model_Filter_Type_Collection extends Model_Collection_Abstract {
 	var $_table = 'filter_types';
 	var $_id = 'id';
 	var $_model = 'Filter/Type';
 	var $_table_desc = 'filter_type_description';
 	var $_table_desc_id = 'ftdid';
 	var $_table_desc_conn_id = 'ftid';
 }