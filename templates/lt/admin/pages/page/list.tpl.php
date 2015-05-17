<?php
/*
 * Created on May 25, 2012
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
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_URL', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_MENU', 'value')->get('value'); ?></th>
		<th>Категорія</th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('name');?></td>
		<td><?php echo $item->get('url');?></td>
		<td><?php echo $item->get('menuname');?></td>
		<td><?php echo '<a class="status-'.(int)$item->get('category').'"></a>';?></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?'.(isset($v['var'])?$v['var']:'id').'=' . $item->get('id'); ?>"<?php if(isset($v['warning'])) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php }?>
</table>