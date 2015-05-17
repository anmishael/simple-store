<?php
/**
 * Created on 17 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 if(sizeof($this->_items)>1) {
?>
<div id="language-bar">
	<ul>
<?php foreach($this->_items as $item) { ?>
		<li><a href="?lng=<?php echo $item->get('code').'&'.$this->_core->getAllGetParams(array('lng')); ?>"><?php echo $item->get('label'); ?></a></li>
<?php } ?>
	</ul>
</div>
<?php } ?>