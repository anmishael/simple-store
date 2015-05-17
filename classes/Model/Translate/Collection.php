<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */

class Model_Translate_Collection extends Model_Collection_Abstract {
	var $_table = 'translate';
	var $_id = 'tid';
	var $_model = 'Translate';
	function get($key) {
		$res = parent::get($key);
		if(!$res instanceof Model_Translate) {
			$res = new Model_Translate(array('value'=>$key, 'key'=>$key));
		}
		return $res;
	}
}