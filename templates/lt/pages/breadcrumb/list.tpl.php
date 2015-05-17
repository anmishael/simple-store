<?php
/**
 * Created on 21 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 ?>
<div id="breadcrumb-list">
<ul>
<?php foreach($this->_items as $k=>$item) { ?>
	<li<?php echo (!isset($this->_items[$k+1])?' class="last"':''); ?>><a href="<?php echo $item->get('url'); ?>"><?php echo $item->get('name'); ?></a></li>
<?php } ?>
</ul>
<div class="clear"></div>
</div>