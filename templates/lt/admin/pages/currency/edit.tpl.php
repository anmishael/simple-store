<?php
/**
 * Created on 18 ����. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" currency</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-currency-save');?>" method="post">
	<table>
	<tr>
	<td><label for="admin-filter-edit-form-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-filter-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
	<td><label for="admin-filter-edit-form-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-filter-edit-form-code" name="code" value="<?php echo $this->_item->get('code')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
	<td><label for="admin-filter-edit-form-default"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_DEFAULT', 'value')->get('value'); ?></label></td>
		<td>
			<input type="radio" name="default" id="admin-filter-edit-form-default-on" value="1"<?php echo ($this->_item->get('default')==1?' checked="checked"':'') ?> /> <label for="admin-filter-edit-form-default-on">On</label><br />
			<input type="radio" name="default" id="admin-filter-edit-form-default-off" value="0"<?php echo ($this->_item->get('default')==0?' checked="checked"':'') ?> /> <label for="admin-filter-edit-form-default-off">Off</label>
		</td>
	</tr>
	<tr>
		<td><label for="admin-filter-edit-form-sortorder"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SORT', 'value')->get('value'); ?></label></td>
		<td><input type="text" class="text" id="admin-filter-edit-form-sortorder" name="sortorder" value="<?php echo $this->_item->get('sortorder')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
		<td><label for="admin-filter-edit-form-value"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VALUE', 'value')->get('value'); ?></label></td>
		<td><input type="text" class="text" id="admin-filter-edit-form-value" name="value" value="<?php echo $this->_item->get('value')?>" size="32" maxlength="255" /></td>
	</tr>
	<tr>
		<td><label for="admin-filter-edit-form-label"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_LABEL', 'value')->get('value'); ?></label></td>
		<td><input type="text" class="text" id="admin-filter-edit-form-label" name="label" value="<?php echo $this->_item->get('label')?>" size="32" maxlength="255" /></td>
	</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-currency-list')); ?>';
	});
});
</script>