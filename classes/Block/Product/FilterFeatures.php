<?php
/*
 * Created on 10 черв. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Block_Product_FilterFeatures extends Block_Display {
 	function init() {
 		
 		$this->fetch('product', 'filterfeatures');
 		return $this;
 	}
 }