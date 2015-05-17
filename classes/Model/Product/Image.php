<?php
/*
 * Created on 5 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */

 class Model_Product_Image extends Model_Object {
 	var $_table = 'images';
 	var $_id = 'id';
 	var $_model = 'Product/Image';
 	function clearThumbnails() {
 		$full_path = $this->_core->getSingleton('Config')->getUnixPath() . $this->get('path');
 		$path = $this->get('path');
 		$pInfo = pathinfo($full_path);
 		$tDir = $pInfo['dirname'] . '/_thumb/';
 		if(file_exists($tDir)) {
	 		$d = dir($tDir);
	 		while(false !== ($entry = $d->read())) {
	 			if(stristr($entry, $pInfo['filename'])) {
	 				if(!unlink($tDir . $entry)) {
	 					$ppInfo = pathinfo($path);
	 					$this->_core->raiseError('Cannot remove thumbnail: ' . $ppInfo['dirname'] . '/_thumb/' . $entry);
	 				}
	 			}
	 		}
 		}
 		return $this;
 	}
 	function remove() {
 		$this->clearThumbnails();
 		unlink($this->_core->getSingleton('Config')->getUnixPath() . $this->get('path'));
 		parent::remove();
 	}
 }