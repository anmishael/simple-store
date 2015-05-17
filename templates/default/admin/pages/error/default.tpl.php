<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 if(sizeof($this->_items)>0) {
 ?>
 <div class="inner-wrapper" id="main-error-area"><div class="inner">
 <h2><?php echo $this->_core->getModel('Translate/Collection')->get('PAGE_ERROR_TITLE')->get('value'); ?></h2>
 <ul>
 <?php foreach($this->_items as $item) { ?>
 	<li><?php echo $item->get('content');?></li>
 <?php } ?>
 </ul></div></div>
 <?php } ?>