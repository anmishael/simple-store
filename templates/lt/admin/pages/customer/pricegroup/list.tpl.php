<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikel
 * Date: 28.03.13
 * Time: 16:58
 * To change this template use File | Settings | File Templates.
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
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_FIELD', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
	<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('name');?></td>
		<td><?php echo $item->get('code');?></td>
		<td><?php echo $item->get('field');?></td>
		<td><?php
			foreach($this->_actions as $k=>$v) { ?>
				<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if($v['warning']) {
					echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('username'))).'\');"';
				} ?>><?php echo $v['name'];?></a>
				<?php } ?></td>
	</tr>
	<?php }?>
</table>
