<?php
/**
 * Created on 19 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * @comment Designed especially for Kinetoscope Media, Inc.
 * @version 1.0
 */
 
 ?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('key')?>" setting</h2>
<?php } else { ?>
	<h2>Add new setting</h2>
<?php } ?>
<form id="admin-setting-edit-form" action="<?php echo $this->_core->getActionUrl('admin-setting-save') . '?' . $this->_core->getAllGetParams(array('id'));?>" method="post">
	<table>
		<tr>
			<td><label for="admin-setting-edit-form-key"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_KEY', 'value')->get('value'); ?></label></td>
			<td><input type="text" class="text" id="admin-setting-edit-form-key" name="key" value="<?php echo $this->_item->get('key')?>" size="32" maxlength="255" /></td>
		</tr>
		<tr>
			<td><label for="admin-setting-edit-form-value"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VALUE', 'value')->get('value'); ?></label></td>
			<td><?php if($this->_item->get('type') == 'password') { ?>
					<input type="password" name="value" value="" />
				<?php } else { ?>
					<textarea type="text" class="text" id="admin-setting-edit-form-value" name="value" cols="6"><?php echo $this->_item->get('value');?></textarea>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td><label for="admin-setting-edit-form-public"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_PUBLIC', 'value')->get('value'); ?></label></td>
			<td>
			<input type="radio" name="public" value="1" id="admin-setting-edit-form-public-on"<?php if($this->_item->get('public') == 1) { ?> checked="checked"<?php }?> /> <label for="admin-setting-edit-form-public-on"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_VISIBLE', 'value')->get('value'); ?></label><br />
			<input type="radio" name="public" value="0" id="admin-setting-edit-form-public-off"<?php if($this->_item->get('public') == 0) { ?> checked="checked"<?php }?> /> <label for="admin-setting-edit-form-public-off"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_HIDDEN', 'value')->get('value'); ?></label></td>
		</tr>
		<?php if($this->_item->get('type') != 'password') { ?>
		<tr>
			<td><label for="admin-setting-edit-form-type"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_TYPE', 'value')->get('value'); ?></label></td>
			<td><select name="type">
				<option value="text">Text</option>
				<option value="password">Password</option>
			</select></td>
		</tr><?php } ?>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('.button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-setting-list') . '?' . $this->_core->getAllGetParams(array('id'))); ?>';
	});
});
</script>