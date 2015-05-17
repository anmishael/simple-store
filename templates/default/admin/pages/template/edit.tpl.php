<?php
/**
 * Created on 18 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?><?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" template</h2>
<?php } ?>
<?php $desc = $this->_item->get('description'); ?>
<form action="<?php echo $this->_core->getActionUrl('admin-template-save');?>" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><label for="admin-template-edit-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label></td>
			<td><input id="admin-template-edit-name" type="text" name="name" value="<?php echo $this->_item->get('name'); ?>" size="64" /></td>
		</tr>
		<tr>
			<td><label for="admin-template-edit-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
			<td><input id="admin-template-edit-code" type="text" name="code" value="<?php echo $this->_item->get('code'); ?>" size="32" /></td>
		</tr>
		<?php foreach($this->_languages as $lang) { ?>
		<tr>
			<td><label for="admin-template-edit-description-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DESCRIPTION', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
			<td><textarea id="admin-template-edit-description-<?php echo $lang->get('id'); ?>" name="description[<?php echo $lang->get('id'); ?>]" rows="3"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('description'):''); ?></textarea></td>
		</tr>
		<tr>
			<td><label for="admin-template-edit-title-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TITLE', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
			<td><input id="admin-template-edit-title-<?php echo $lang->get('id'); ?>" type="text-<?php echo $lang->get('id'); ?>" name="title[<?php echo $lang->get('id'); ?>]" value="<?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('title'):''); ?>" size="76" /></td>
		</tr>
		<tr>
			<td><label for="admin-template-edit-content-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CONTENT', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
			<td><textarea id="admin-template-edit-content-<?php echo $lang->get('id'); ?>" name="content[<?php echo $lang->get('id'); ?>]" rows="24"><?php echo htmlspecialchars($desc[$lang->get('id')]?$desc[$lang->get('id')]->get('content'):''); ?></textarea></td>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('.button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-template-list')); ?>';
	});
});
</script>