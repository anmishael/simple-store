<?php
/*
 * Created on May 30, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 class Block_Product_SmallFilter extends Block_Display {
 	var $_items, $_filters;
 	function init() {
 		$this->_filters = array(
 				'location'=>$_POST['location']?$_POST['location']:'',
 				'price-min'=>array(
 						array('value'=>0, 'name'=>'$0'),
 						array('value'=>100, 'name'=>'$100'),
 						array('value'=>500, 'name'=>'$500'),
 						array('value'=>5000, 'name'=>'$5.000')
 					),
 				'price-max'=>array(
 						array('value'=>-1, 'name'=>'&infin;'),
 						array('value'=>500, 'name'=>'$500'),
 						array('value'=>1000, 'name'=>'$1.000')
 						
 					),
 				'beds'=>array(
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>1, 'name'=>'1'),
 						array('value'=>2, 'name'=>'2'),
 						array('value'=>3, 'name'=>'3')
 					),
 				'baths'=>array(
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>1, 'name'=>'1'),
 						array('value'=>2, 'name'=>'2'),
 						array('value'=>3, 'name'=>'3')
 					),
 				'square-min'=>array(
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>100, 'name'=>'100'),
 						array('value'=>200, 'name'=>'200'),
 						array('value'=>400, 'name'=>'400')
 					),
 				'square-max'=>array(
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>100, 'name'=>'100'),
 						array('value'=>200, 'name'=>'200'),
 						array('value'=>400, 'name'=>'400')
 					),
 				'furnished'=>array(
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>1, 'name'=>'furnished')
 					),
 				'radius'=>array(
 						array('value'=>0, 'name'=>'exact'),
 						array('value'=>-1, 'name'=>'No limit'),
 						array('value'=>20, 'name'=>'20 miles'),
 						array('value'=>50, 'name'=>'50 miles')
 					),
 				'sort'=>array(
 						array('value'=>-1, 'name'=>'Default'),
 						array('value'=>'name', 'name'=>'Name'),
 						array('value'=>'price', 'name'=>'Price')
 					)
 			);
 		$types = $this->_core->getModel('Product/Type/Collection')->clear()->getCollection();
 		$_art = array();
 		foreach($types as $k=>$v) {
 			$_art[] = array('value'=>$v->get('id'), 'name'=>$v->get('name'));
 		}
 		if(sizeof($_art)>0) {
 			$this->_filters['types'] = $_art;
 		}
 		$this->fetch('product', 'smallfilter');
 		return $this;
 	}
 }