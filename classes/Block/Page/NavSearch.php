<?php
/**
 * File: BlockSearch.php
 * Created on 20.05.2012
 *
 * @author      Mikel Annjuk <support@widesoftware.com>
 */

 class Block_Page_NavSearch extends Block_Display {
 	function init() {
 		$this->fetch('page', 'navsearch');
 		return $this;
 	}
 }