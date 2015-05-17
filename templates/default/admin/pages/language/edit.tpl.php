<?php
/**
 * Created on 3 ���. 2012
 *
 * @author Mikel Annjuk <anmishael@gmail.com>
 * 
 */
?>
<?php if($this->_item->get('id')) { ?>
	<h2>Edit "<?php echo $this->_item->get('name')?>" page</h2>
<?php } ?>
<form action="<?php echo $this->_core->getActionUrl('admin-language-save');?>" method="post">
	<table>
	<tr>
	<td><label for="admin-page-edit-form-name"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_NAME', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-page-edit-form-name" name="name" value="<?php echo $this->_item->get('name')?>" size="64" maxlength="255" /></td>
	</tr>
	<tr>
	<td><label for="admin-page-edit-form-code"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CODE', 'value')->get('value'); ?></label></td>
	<td><input type="text" class="text" id="admin-page-edit-form-code" name="code" value="<?php echo $this->_item->get('code')?>" size="9" maxlength="16" /></td>
	</tr>
	<tr>
	<td><label for="admin-page-edit-form-status"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_STATUS', 'value')->get('value'); ?></label></td>
	<td>
		<input type="radio" id="admin-page-edit-form-status-on" name="status" value="1"<?php if((int)$this->_item->get('status') == 1) {  ?> checked="checked"<?php } ?> /><label for="admin-page-edit-form-status-on"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_ON', 'value')->get('value'); ?></label><br />
		<input type="radio" id="admin-page-edit-form-status-off" name="status" value="0"<?php if((int)$this->_item->get('status') != 1) {  ?> checked="checked"<?php } ?> /><label for="admin-page-edit-form-status-off"><?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_OFF', 'value')->get('value'); ?></label><br />
	</td>
	</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->_item->get('id'); ?>" />
	<input type="button" class="button" id="button-cancel" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_CANCEL', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_APPLY', 'value')->get('value'); ?>" />
	<input type="submit" class="button" name="_save" value="<?php echo $this->_core->getModel('Translate/Collection')->get('ADMIN_TEXT_SAVE', 'value')->get('value'); ?>" />
</form>
<script type="text/javascript">
$(document).ready(function() {
	$('#button-cancel').bind('click', function() {
		window.location = '<?php echo addslashes($this->_core->getActionUrl('admin-language-list') . '?' . $this->_core->getAllGetParams(array('id'))); ?>';
	});
});
</script>