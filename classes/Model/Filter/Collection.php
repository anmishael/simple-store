<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Model_Filter_Collection extends Model_Collection_Abstract {
 	var $_table = 'filters';
 	var $_id = 'id';
 	var $_table_desc = 'filter_description';
 	var $_table_desc_id = 'fdid';
 	var $_table_desc_conn_id = 'fid';
 	var $_model = 'Filter';
 }