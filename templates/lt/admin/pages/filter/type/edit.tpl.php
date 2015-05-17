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
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" filter type</h2>
<?php } ?>
<?php $desc = $this->_item->get('description'); ?>
<form action="<?php echo $this->_core->getActionUrl('admin-filter-type-save');?>" method="post">
	<table>
	<?php foreach($this->_languages as $lang) { ?>
	<tr>
	<td><label for="admin-filter-type-edit-form-name-<?php echo $lang->get('id'); ?>"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?> (<strong><?php echo $lang->get('name');?></strong>)</label></td>
	<td><input type="text" class="text" id="admin-filter-type-edit-form-name-<?php echo $lang->get('id'); ?>" name="name[<?php echo $lang->get('id'); ?>]" value="<?php echo $desc[$lang->get('id')]?$desc[$lang->get('id')]->get('name'):''; ?>" size="32" maxlength="255" /></td>
	</tr>
	<?php } ?>
	<tr>
	<td><label for="admin-filter-type-edit-form-display"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DISPLAY', 'value')->get('value'); ?></label></td>
	<td><select id="admin-filter-type-edit-form-display" name="display">
	<?php foreach($this->_item->_arrDisplay as $k=>$v) { ?>
		<option value="<?php echo $v; ?>"<?php if($v == $this->_item->get('display')) { ?> selected="selected"<?php } ?>><?php echo $v; ?></option>
	<?php } ?>
	</select></td>
	</tr>
	<tr>
	<td><label for="admin-filter-type-edit-form-url"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_URL', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-filter-type-edit-form-url" name="url" value="<?php echo $this->_item->get('url')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
	<td><label for="admin-filter-type-edit-form-status"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
	<td><select name="status" id="admin-filter-type-edit-form-status">
		<option value="0"<?php echo (int)$this->_item->get('status') == 0 ? ' selected="selected"' : ''?>><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_OFF', 'value')->get('value'); ?></option>
		<option value="1"<?php echo (int)$this->_item->get('status') == 1 ? ' selected="selected"' : ''?>><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ON', 'value')->get('value'); ?></option>
	</select></td>
	</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-filter-type-list')); ?>';
	});
});
</script>