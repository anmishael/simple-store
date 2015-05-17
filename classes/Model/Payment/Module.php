<?php
/*
 * Created on 25 Кві 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Model_Payment_Module extends Model_Object {
 	function getConfig() {
 		$cl = explode('_', get_class($this));
		array_pop($cl);
		return Core::getModel('Payment/Collection')->getPaymentModule(array_pop($cl));
 	}
 }
?>