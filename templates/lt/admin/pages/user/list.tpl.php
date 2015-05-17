<?php
/*
 * Created on May 27, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<ul class="links-list">
<?php foreach($this->_toplinks as $k=>$link) { ?>
	<li><a href="<?php echo $link['url']?>"><?php echo $link['name'];?></a></li>
<?php } ?>
</ul>
<table class="list" cellspacing="0" cellpadding="0">
	<tr>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_USERNAME', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_FIRST', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME_LAST', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_EMAIL', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('username');?></td>
		<td><?php echo $item->get('name_first');?></td>
		<td><?php echo $item->get('name_last');?></td>
		<td><?php echo $item->get('email');?></td>
		<td><?php echo $this->_arrtypes[$item->get('typeid')]['name'];?></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if($v['warning']) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php }?>
</table>
