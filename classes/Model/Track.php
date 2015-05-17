<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 30.03.13
 * Time: 10:11
 * To change this template use File | Settings | File Templates.
 */
class Model_Track extends Model_Object {
	function __construct($data) {
		parent::__construct($data);
		if(!file_exists($this->get('path'))) {
			$fo = fopen($this->get('path'), 'w');
			fclose($fo);
		}
	}
	function read() {
	}
	function save() {
		$tdata = $this->toArray();
		$arrstr = array();
		foreach($tdata as $k=>$v) {
			if($k!='path') {
				$arrstr[] = $k . ':' . $v;
			}
		}
		$fo = fopen($this->get('path'), 'w');
		$str = implode(',', $arrstr);
		fputs($fo, $str);
		fclose($fo);
	}
}
