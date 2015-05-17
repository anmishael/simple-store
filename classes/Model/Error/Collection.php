<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

class Model_Error_Collection extends Model_Collection_Abstract {
	function __construct() {
		parent::__construct();
		if(isset($_SESSION['errors'])) {
			$arr = unserialize($_SESSION['errors']);
			foreach($arr as $k=>$v) {
				$this->put($this->_core->getModel('Error')->newInstance(array('title'=>$v['title'], 'content'=>$v['content'])));
			}
			unset($_SESSION['errors']);
		}
	}
	function pushToSession() {
		$_SESSION['errors'] = serialize($this->toArray());
	}

}