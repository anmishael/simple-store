<?php
/*
 * Created on 9 ����. 2012
 *
 * @author Mikel Annjuk <mikel@widesoftware.com>
 * @copy WIDE Software Inc. 2011
 * @site http://www.widesoftware.com
 * @license GNU/GPL
 */
?>
<ul class="links-list">
<?php foreach($this->_toplinks as $k=>$link) { ?>
	<li><a href="<?php echo $link['url']?>"><?php echo $link['name'];?></a></li>
<?php } ?>
</ul>
<?php if($this->_type instanceof Model_Filter_Type && $this->_type->get('id')) { ?>
	<h3>Filters assigned to "<?php echo $this->_type->get('name');?>"</h3>
<?php } ?>
<table class="list" cellspacing="0" cellpadding="0">
	<tr>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_URL', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></th>
		<th><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ACTION', 'value')->get('value'); ?></th>
	</tr>
<?php foreach($this->_items as $k=>$item) { ?>
	<tr>
		<td><?php echo $item->get('name');?></td>
		<td><?php echo $item->get('url');?></td>
		<td><?php echo (isset($this->_types[$item->get('type')]) && is_object($this->_types[$item->get('type')])) ? $this->_types[$item->get('type')]->get('name') : '';?></td>
		<td class="middle"><a class="status status-<?php echo $item->get('status'); ?>" href="<?php echo $this->_core->getSingleton('Config')->adminUrl; ?>filter/status?id=<?php echo $item->get('id') . '&' . $this->_core->getAllGetParams(array('id')); ?>"></a></td>
		<td><?php
		foreach($this->_actions as $k=>$v) { ?>
			<a href="<?php echo $v['url'] . '?id=' . $item->get('id'); ?>"<?php if(isset($v['warning'])) { 
				echo ' onclick="return confirm(\''.htmlspecialchars(sprintf($v['warning'], $item->get('name'))).'\');"';
			 } ?>><?php echo $v['name'];?></a>
		<?php } ?></td>
	</tr>
<?php }?>
</table>