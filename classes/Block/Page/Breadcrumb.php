<?php
/*
 * Created on 19 черв. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */

 class Block_Page_Breadcrumb extends Block_Display {
 	function init() {
 		$this->fetch('page', 'breadcrumb');
 		return $this;
 	}
 }